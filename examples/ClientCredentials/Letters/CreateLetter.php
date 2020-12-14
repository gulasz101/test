<?php

declare(strict_types=1);

use Pingen\Endpoints\LettersEndpoint;
use Pingen\Endpoints\UserAssociationsEndpoint;
use Pingen\Models\UserAssociationItem;
use Pingen\Models\Letter\LetterInputPOSTAttributes;

$provider = require __DIR__ . '/../provider.php';

$userAssociationsEndpoint = new UserAssociationsEndpoint($provider);
/** @var UserAssociationItem $association */
$association = collect($userAssociationsEndpoint->getCollection()->data)
    ->filter(fn (UserAssociationItem $item) => $item->attributes->status == 'active')
    ->first();

$lettersEndpoint = (new LettersEndpoint($provider))
    ->setCompanyId($association->relationships->company->data->id);

$imagineThisIsValidPDF = tmpfile();
fwrite($imagineThisIsValidPDF, 'Valid pdf contents.');

try {
    $letterDetails = $lettersEndpoint->store(
        (new LetterInputPOSTAttributes())
            ->setFileOriginalName('valid.pdf')
            ->setAddressPosition('left')
            ->setAutoSend(false)
            ->attachFile($imagineThisIsValidPDF)
    );
    dump($letterDetails);
} catch (\Pingen\Exceptions\JsonApiException $apiException) {
    dump($apiException->getBody());
}

