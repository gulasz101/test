<?php

declare(strict_types=1);

namespace Pingen\Endpoints;

use Pingen\Endpoint;
use Pingen\Models\CompanyDetails;
use Pingen\Models\CompanyInputPOSTAttributes;

/**
 * Class CompaniesEndpoint
 * @package Pingen\Endpoints
 */
class CompaniesEndpoint extends Endpoint
{
    /**
     * @param CompanyInputPOSTAttributes $attributes
     * @return CompanyDetails
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function store(CompanyInputPOSTAttributes $attributes)
    {
        return new CompanyDetails(
            $this->performPostJonApiRequest(
                '/companies',
                'companies',
                $attributes
            )
                ->json()
        );
    }
}
