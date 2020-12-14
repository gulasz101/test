<?php

declare(strict_types=1);

use Pingen\Endpoints\ParameterBags\UserAssociationCollectionParameterBag;
use Pingen\Endpoints\UserAssociationsEndpoint;
use Pingen\Exceptions\RateLimitJsonApiException;

$provider = require 'provider.php';

$parameters = (new UserAssociationCollectionParameterBag())->setPageLimit(1);
$endpoint = new UserAssociationsEndpoint($provider);

function loopThroughAll(UserAssociationsEndpoint $endpoint, UserAssociationCollectionParameterBag $listParameterBag): void
{
    try {
        do {
            $associations = $endpoint->getCollection($listParameterBag);

            foreach ($associations->data as $associationItem) {
                dump(json_encode($associationItem->attributes->toArray()));
            }

            $listParameterBag = ($listParameterBag ?? new UserAssociationCollectionParameterBag())
                ->setPageNumber($associations->meta->current_page + 1);
        } while ($associations->links->next);
    } catch (RateLimitJsonApiException $rateLimitJsonApiException) {
        sleep($rateLimitJsonApiException->retryAfter);

        loopThroughAll($endpoint, $listParameterBag);
    }
}

loopThroughAll($endpoint, $parameters);
