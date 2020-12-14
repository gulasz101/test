<?php

declare(strict_types=1);

require __DIR__ . '/../../../vendor/autoload.php';

$provider = require __DIR__ . '/../provider.php';

/** @var \Pingen\Endpoints\LettersEndpoint $endpoint */
$endpoint = (new \Pingen\Endpoints\LettersEndpoint($provider))
    ->setCompanyId('499b5c25-d68b-4426-bbb3-3dc13fee8a83');

$letterCollection = $endpoint->getCollection();

foreach ($letterCollection->data as $entry) {
    dump($entry->attributes->status);
}
