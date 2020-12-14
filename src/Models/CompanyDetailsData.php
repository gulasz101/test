<?php

declare(strict_types=1);

namespace Pingen\Models;

use Pingen\Models\General\ItemLinks;
use Pingen\Models\General\RelationshipRelatedMany;
use Pingen\Support\DataTransferObject;

/**
 * Class CompanyDetailsData
 * @package Pingen\Models
 */
class CompanyDetailsData extends DataTransferObject
{
    public ?string $id;

    public string $type = 'companies';

    public CompanyItemAttributes $attributes;

    public ?RelationshipRelatedMany $relationships;

    public ?ItemLinks $links;
}
