<?php

declare(strict_types=1);

namespace Pingen;

use Carbon\CarbonImmutable;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use League\OAuth2\Client\Token\AccessToken;
use Pingen\Exceptions\JsonApiException;
use Pingen\Exceptions\RateLimitJsonApiException;
use Pingen\Support\DataTransferObject;
use Pingen\Support\Input;
use Pingen\Support\ListParameterBag;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class Endpoint
 * @package Pingen
 */
abstract class Endpoint
{
    protected Pingen $provider;

    protected string $baseUrl;

    protected ?AccessToken $accessToken = null;

    /**
     * Endpoint constructor.
     * @param Pingen $pingen
     */
    public function __construct(Pingen $pingen)
    {
        $this
            ->setProvider($pingen)
            ->setBaseUrl($pingen->getBaseUrl());

        DataTransferObject::$makers[CarbonImmutable::class] = fn ($value): ?CarbonImmutable => CarbonImmutable::make($value);
    }

    /**
     * @param Pingen $provider
     * @return Endpoint
     */
    public function setProvider(Pingen $provider): self
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @param string $baseUrl
     * @return Endpoint
     */
    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * @param string $endpoint
     * @param ListParameterBag $listParameterBag
     * @return Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    protected function performGetCollectionRequest(
        string $endpoint,
        ?ListParameterBag $listParameterBag = null
    ): Response {
        return $this->setOnErrorCallbackForJsonApiResponses(
            $this->getAuthenticatedJsonApiRequest()
                ->get(
                    $this->baseUrl . $endpoint,
                    ($listParameterBag ?? new ListParameterBag())->all()
                )
        );
    }

    /**
     * @param string $endpoint
     * @param ParameterBag|null $parameterBag
     * @return Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    protected function performGetDetailsRequest(string $endpoint, ?ParameterBag $parameterBag = null): Response
    {
        return $this->setOnErrorCallbackForJsonApiResponses(
            $this->getAuthenticatedJsonApiRequest()
                ->get(
                    $this->baseUrl . $endpoint,
                    ($parameterBag ?? new ParameterBag())->all()
                )
        );
    }

    /**
     * @param string $endpoint
     * @param string $type
     * @param Input $body
     * @return Response
     * @throws \Illuminate\Http\Client\RequestException
     */
    protected function performPostJonApiRequest(string $endpoint, string $type, Input $body)
    {
        return $this->setOnErrorCallbackForJsonApiResponses(
            $this->getAuthenticatedJsonApiRequest()
                ->post(
                    $this->baseUrl . $endpoint,
                    array(
                        'data' => array(
                            'type' => $type,
                            'attributes' => $body->toArray(),
                        ),
                    )
                )
        );
    }

    /**
     * @return PendingRequest
     */
    protected function getAuthenticatedJsonApiRequest(): PendingRequest
    {
        return $this->getAuthenticatedRequest()
            ->accept('application/vnd.api+json')
            ->contentType('application/vnd.api+json');
    }

    /**
     * @return PendingRequest
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    protected function getAuthenticatedRequest(): PendingRequest
    {
        return $this->provider->getClient()
            ->timeout(Pingen::DEFAULT_TIMEOUT)
            ->withToken($this->provider->obtainAccessToken()->getToken());
    }

    /**
     * @param Response $response
     * @return Response
     * @throws JsonApiException
     */
    protected function setOnErrorCallbackForJsonApiResponses(Response $response): Response
    {
        return $response->onError(
            function (Response $response): void {
                if ($response->status() === \Symfony\Component\HttpFoundation\Response::HTTP_TOO_MANY_REQUESTS) {
                    throw new RateLimitJsonApiException($response);
                }
                throw new JsonApiException($response);
            }
        );
    }
}
