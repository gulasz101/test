<?php

declare(strict_types=1);

namespace Pingen\Models;

use Pingen\Models\General\ItemLinks;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class UserAssociationItem
 * @package Pingen\Models
 */
class UserAssociationItem extends DataTransferObject
{
    public string $type;

    public string $id;

    public UserAssociationItemAttributes $attributes;

    public ?ItemLinks $links;

    public ?UserAssociationRelationships $relationships;
}
