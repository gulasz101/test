<?php

declare(strict_types=1);

namespace Pingen;

use Carbon\Carbon;
use Illuminate\Http\Client\Factory as HttpClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Pingen
 * @package Pingen
 */
class Pingen extends AbstractProvider
{
    use BearerAuthorizationTrait;

    public const DEFAULT_TIMEOUT = 20;

    protected ?AccessTokenInterface $accessToken = null;

    protected ?string $refreshToken = null;

    protected HttpClient $client;

    protected string $baseUrl = 'https://api.v2.pingen.com';

    protected string $authUrl = 'https://identity.pingen.com';

    /**
     * Constructs an OAuth 2.0 service provider.
     *
     * @param array $options An array of options to set on this provider.
     *     Options include `clientId`, `clientSecret`, `redirectUri`, and `state`.
     *     Individual providers may introduce more options, as needed.
     * @param array $collaborators An array of collaborators that may be used to
     *     override this provider's default behavior. Collaborators include
     *     `grantFactory`, `requestFactory`, and `httpClient`.
     *     Individual providers may introduce more collaborators, as needed.
     */
    public function __construct(array $options = array(), array $collaborators = array())
    {
        $this->client = (new HttpClient());

        if ($baseUrl = Arr::get($options, 'baseUrl')) {
            $this->baseUrl = $baseUrl;
        }

        if ($authUrl = Arr::get($options, 'authUrl')) {
            $this->authUrl = $authUrl;
        }

        parent::__construct(
            $options,
            array_merge(
                array(
                    'httpClient' => $this->client
                        ->baseUrl($this->baseUrl)
                        ->timeout(self::DEFAULT_TIMEOUT)
                        ->buildClient(),
                ),
                $collaborators
            )
        );
    }

    /**
     * Sends a request instance and returns a response instance.
     *
     * WARNING: This method does not attempt to catch exceptions caused by HTTP
     * errors! It is recommended to wrap this method in a try/catch block.
     *
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function getResponse(RequestInterface $request)
    {
        return $this->client
            ->withHeaders($request->getHeaders())
            ->withOptions(array(
                'body' => (string) $request->getBody(),
            ))
            ->withBody(urlencode((string) $request->getBody()), $request->getHeader('Content-Type')[0])
            ->send($request->getMethod(), (string) $request->getUri())
            ->toPsrResponse();
    }

    /**
     * Returns the base URL for authorizing a client.
     *
     * Eg. https://oauth.service.com/authorize
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->authUrl . '/auth/authorize';
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * Eg. https://oauth.service.com/token
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->authUrl . '/auth/access-tokens';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->baseUrl . '/user';
    }

    /**
     * @return mixed|string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return HttpClient
     */
    public function getClient(): HttpClient
    {
        return $this->client;
    }

    /**
     * @param HttpClient $client
     * @return Pingen
     */
    public function setClient(HttpClient $client): self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @param AccessToken|null $accessToken
     * @return Pingen
     */
    public function setAccessToken(?AccessToken $accessToken): self
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @param string|null $refreshToken
     * @return Pingen
     */
    public function setRefreshToken(?string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    public function setAccessTokenFromString(string $accessToken): self
    {
        $expiresAt = (string) Str::of((string) base64_decode(str_replace(array('-', '_'), array('+', '/'), $accessToken), true))
            ->match('/(?<=exp\"\:)(.*)(?=\,\"sub)/');

        if (! $expiresAt) {
            throw new \InvalidArgumentException('Passed token does not look valid');
        }

        return $this->setAccessToken(
            new AccessToken(
                array(
                    'access_token' => $accessToken,
                    'expires_in' => (int) Carbon::now()->diffInSeconds(Carbon::createFromTimestamp($expiresAt)),
                )
            )
        );
    }

    /**
     * @throws IdentityProviderException
     */
    public function obtainAccessToken(): AccessTokenInterface
    {
        if (! $this->accessToken || $this->accessToken->hasExpired()) {
            if (! $this->refreshToken) {
                $this->accessToken = $this->getAccessToken(
                    'client_credentials'
                );
            } else {
                $this->accessToken = $this->getAccessToken(
                    'refresh_token',
                    array(
                        'refresh_token' => $this->refreshToken,
                    )
                );
            }
        }

        return $this->accessToken;
    }

    /**
     * Returns the default scopes used by this provider.
     *
     * This should only be the scopes that are required to request the details
     * of the resource owner, rather than all the available scopes.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return array('user');
    }

    /**
     * Checks a provider response for errors.
     *
     * @param ResponseInterface $response
     * @param array|string $data Parsed response data
     * @return void
     * @throws IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        // http client will throw exception
    }

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new ResourceOwner($response);
    }
}
