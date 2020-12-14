<?php

declare(strict_types=1);

namespace Pingen\Models;

use Pingen\Models\General\RelationshipRelatedMany;
use Pingen\Support\DataTransferObject;

/**
 * Class CompanyRelationships
 * @package Pingen\Models
 */
class CompanyRelationships extends DataTransferObject
{
    public ?RelationshipRelatedMany $associations;
}
