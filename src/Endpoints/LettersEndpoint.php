<?php

declare(strict_types=1);

namespace Pingen\Endpoints;

use Pingen\Endpoint;
use Pingen\Endpoints\ParameterBags\LetterCollectionParameterBag;
use Pingen\Models\Letter\LetterCollection;
use Pingen\Models\Letter\LetterDetails;
use Pingen\Models\Letter\LetterInputPOSTAttributes;
use Pingen\Support\HasCompanyContext;

/**
 * Class LettersEndpoint
 * @package Pingen\Endpoints
 */
class LettersEndpoint extends Endpoint
{
    use HasCompanyContext;

    /**
     * @param LetterCollectionParameterBag|null $letterCollectionParameterBag
     * @return LetterCollection
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getCollection(?LetterCollectionParameterBag $letterCollectionParameterBag = null): LetterCollection
    {
        return new LetterCollection(
            $this
                ->performGetCollectionRequest(
                    sprintf('/companies/%s/letters/', $this->getCompanyId()),
                    $letterCollectionParameterBag
                )->json()
        );
    }

    /**
     * @param LetterInputPOSTAttributes $attributes
     * @return LetterDetails
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function store(LetterInputPOSTAttributes $attributes): LetterDetails
    {
        $attributes->setProvider($this->provider);

        return new LetterDetails(
            $this->performPostJonApiRequest(
                sprintf('/companies/%s/letters/', $this->getCompanyId()),
                'letters',
                $attributes
            )
                ->json()
        );
    }
}
