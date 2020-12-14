<?php

declare(strict_types=1);

namespace Pingen\Models;

use Pingen\Support\DataTransferObject;

/**
 * Class CompanyDetails
 * @package Pingen\Models\General
 */
class CompanyDetails extends DataTransferObject
{
    public CompanyDetailsData $data;
}
