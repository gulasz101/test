<?php

declare(strict_types=1);

use Pingen\Endpoints\CompaniesEndpoint;
use Pingen\Models\CompanyInputPOSTAttributes;

$provider = require 'provider.php';

$endpoint = new CompaniesEndpoint($provider);

try {
    $company = $endpoint->store(
        (new CompanyInputPOSTAttributes())
            ->setName('Some very custom name')
            ->setStreet('street')
            ->setCity('city')
            ->setCountry('CH')
            ->setLegalForm('GMBH')
            ->setForeignCurrencies(true)
            ->setZip('9630')
            ->setColor('#8A0AF8')
    );

    dump($company->data->attributes->name);
} catch (\Illuminate\Http\Client\RequestException $requestException) {
    dd(
        $requestException->response
    );
}
