<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Str;
use Pingen\Endpoints\UserAssociationsEndpoint;
use Pingen\Pingen;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DummyTest
 * @package Tests
 */
class DummyTest extends \PHPUnit\Framework\TestCase
{
    protected Pingen $provider;

    protected function setUp(): void
    {
        parent::setUp();

        $this->provider = new Pingen(
            array(
                'clientId' => 'clientId',
                'clientSecret' => 'clientSecret',
                'baseUrl' => 'http://nonexistantapi',
                'authUrl' => 'http://nonexistantauth',
            )
        );
    }

    /**
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function testAccessTokenWasIssued(): void
    {
        $this->fakeHttpClient(
            array(
                '/auth/access-tokens' => $this->provider
                    ->getClient()
                    ->sequence()
                    ->push(
                        '{"token_type":"Bearer","expires_in":43200,"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI1VktVVTFTMU9ZUks0SEJZQ1RNSyIsImp0aSI6IjA3ZjlhMWYyOTQzMzdjZTdkYTQxZmVjZjFlMzAzNmY0Y2FkNmNhZjUwY2Q4NTdiMmMxY2FiYjdmMzhmZjhhYWRiOTE3YTJiNjA1M2FiMGUwIiwiaWF0IjoxNjA3NDUxODk2LCJuYmYiOjE2MDc0NTE4OTYsImV4cCI6MTYwNzQ5NTA5Niwic3ViIjoiMSIsInNjb3BlcyI6WyJsZXR0ZXIiLCJtYW5hZ2VtZW50IiwidXNlciJdfQ.eUL5BZSGSEpJdp3lyGPs0yjmMzg7ghg5kFQvZKR6jYoSozS8gELbvApYaCggBiDSUX4CbXyXN5OYKrDOpyzO0RBC4ixl7thaqjoJFY3Km3W0Jy6NyIp6N-YEGxM3kL6zEdEu6p5-0k2pwXzeimiVSgj7XKZqb3OqGq-Oo4UkBwDbMisxA-ePZeGAr1LGRECvzfh5QWYt99LImj_dX0W7mSuWEDTy2LW-mKQNDYFxbCI6Y6ZYUe2IhenK_VlXeOjhprq9S-l2ggOT-d1gSRSZbZ_Uqd1KMonXyc2yVVNfkv_bnIzq48c40-XJ7D7hGGLYAvQG6xYsFtDrC_KnAdGXIBcvD_S13Hz4FGxzs30jYoSNmnfwuxoiMue6rxM1BwKxYZdq3nbKJosdi86i1c7nXtzUedBYBvKpczVWvV1f6myhVqsuTTLFVNdQBM6LgEGlDqE88xkLEi1IwZWNUfBs_1HQg0nNAdZkeRZI-2Up32I3VRTRLK6DP8DjJ3S4BSY5NAsXOjWdINbc7U2h1kaueLCM1hZUPYdCMhveacx9BfvN4mcNuC8UkNnlbWoRIJz8Yj8HnvkrGpxFCtv_qJvKT4eIRAD1jwtVXHkg1sva0nId4UguluQMkKhP_TXADEDIvk5LMIDmoBjWsny7Sa4pm2gBZH_B5Z4UzxOoITsCZ10"}',
                        Response::HTTP_OK,
                        array(
                            'Content-Type' => 'application/json',
                        )
                    ),
                '/user/associations' => $this->provider
                    ->getClient()
                    ->sequence()
                    ->push(
                        '{"data": [], "links": {"first": "string", "last": "string", "prev": null, "next": null, "self": "string"}, "meta": {"current_page": 1, "last_page": 1, "per_page": 20, "from": 1, "to": 1, "total": 1}}',
                        Response::HTTP_OK,
                        array(
                            'Content-Type' => 'application/json',
                        )
                    ),
            )
        );

        $endpoint = new UserAssociationsEndpoint($this->provider);

        $endpoint->getCollection();

        $requestsMatchingCriteria = $this->provider->getClient()->recorded(
            function (Request $request, \Illuminate\Http\Client\Response $response) {
                return Str::of($request->url())->contains('/auth/access-tokens') ||
                    Str::of($request->url())->contains('/user/associations');
            }
        );

        $this->assertCount(2, $requestsMatchingCriteria, 'Failed asserting request was sent.');
    }

    protected function fakeHttpClient(array $sequence): void
    {
        $this->provider->setClient(
            $this->provider->getClient()->fake($sequence)
        );
    }
}
