<?php

declare(strict_types=1);

use Pingen\Endpoints\UserAssociationsEndpoint;
use Pingen\Endpoints\ParameterBags\UserAssociationCollectionParameterBag;

$provider = require 'provider.php';

$endpoint = new UserAssociationsEndpoint($provider);

$response = $endpoint->getCollection(
    (new UserAssociationCollectionParameterBag())
        ->setFilter(
            [
                'and' => [
                    ['role' => 'owner'],
                    ['status' => 'pending']
                ]
            ]
        )
);

dump($response);