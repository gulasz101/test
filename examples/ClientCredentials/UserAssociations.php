<?php

declare(strict_types=1);

use Pingen\Endpoints\ParameterBags\UserAssociationCollectionParameterBag;
use Pingen\Endpoints\UserAssociationsEndpoint;
use Pingen\Models\CompanyItem;

$provider = require 'provider.php';

$endpoint = new UserAssociationsEndpoint($provider);
$associations = $endpoint->getCollection((new UserAssociationCollectionParameterBag())->setInclude(array('company')));

foreach ($associations->data as $associationItem) {

    /** @var CompanyItem $associatedCompany */
    $associatedCompany = collect($associations->included)
        ->filter(fn ($item) => $item->id === $associationItem->relationships->company->data->id)
        ->first();

    dump($associatedCompany->attributes->name);
}
