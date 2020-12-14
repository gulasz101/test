<?php

declare(strict_types=1);

namespace Pingen\Endpoints;

use Pingen\Endpoint;
use Pingen\Endpoints\ParameterBags\UserAssociationCollectionParameterBag;
use Pingen\Endpoints\ParameterBags\UserAssociationParameterBag;
use Pingen\Exceptions\RateLimitJsonApiException;
use Pingen\Models\UserAssociationDetails;
use Pingen\Models\UserAssociationItem;
use Pingen\Models\UserAssociationsCollection;

/**
 * Class UserAssociationsEndpoint
 * @package Pingen\Endpoints
 */
class UserAssociationsEndpoint extends Endpoint
{
    /**
     * @param UserAssociationCollectionParameterBag|null $listParameterBag
     * @return UserAssociationsCollection
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getCollection(?UserAssociationCollectionParameterBag $listParameterBag = null): UserAssociationsCollection
    {
        return new UserAssociationsCollection(
            $this
                ->performGetCollectionRequest(
                    '/user/associations',
                    $listParameterBag
                )
                ->json()
        );
    }

    /**
     * @param UserAssociationCollectionParameterBag|null $listParameterBag
     * @return \Generator|UserAssociationItem[]
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function collectAll(?UserAssociationCollectionParameterBag $listParameterBag = null)
    {
        try {
            do {
                $associations = $this->getCollection($listParameterBag);

                foreach ($associations->data as $userAssociationItem) {
                    yield $userAssociationItem;
                }

                $listParameterBag = ($listParameterBag ?? new UserAssociationCollectionParameterBag())
                    ->setPageNumber($associations->meta->current_page + 1);
            } while ($associations->links->next);
        } catch (RateLimitJsonApiException $rateLimitJsonApiException) {
            sleep($rateLimitJsonApiException->retryAfter);

            $this->collectAll($listParameterBag);
        }
    }

    /**
     * @param string $associationId
     * @param UserAssociationParameterBag|null $parameterBag
     * @return UserAssociationDetails
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getDetails(string $associationId, ?UserAssociationParameterBag $parameterBag = null): UserAssociationDetails
    {
        return new UserAssociationDetails(
            $this->performGetDetailsRequest(
                '/user/associations/' . $associationId,
                $parameterBag
            )->json()
        );
    }
}
