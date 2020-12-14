<?php

declare(strict_types=1);

namespace Pingen\Models;

use Pingen\Models\General\RelationshipRelatedItem;
use Pingen\Support\DataTransferObject;

/**
 * Class UserAssociationRelationships
 * @package Pingen\Models
 */
class UserAssociationRelationships extends DataTransferObject
{
    public RelationshipRelatedItem $company;
}
