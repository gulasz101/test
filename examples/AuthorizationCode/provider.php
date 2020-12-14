<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (\Throwable $exception) {
    // if there is no .env file ignore that, assume that env variables were set inline
}

return new \Pingen\Pingen(
    array(
        'clientId' => env('CLIENT_ID', function (): void {
            throw new InvalidArgumentException('CLIENT_ID');
        }),
        'clientSecret' => env('CLIENT_SECRET', function (): void {
            throw new InvalidArgumentException('CLIENT_SECRET');
        }),
        'redirectUri' => env('REDIRECT_URI', function (): void {
            throw new InvalidArgumentException('REDIRECT_URI');
        }),
        'baseUrl' => env('BASE_URL'),
        'authUrl' => env('AUTH_URL'),
    )
);
