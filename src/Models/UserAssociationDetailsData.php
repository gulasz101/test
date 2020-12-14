<?php

declare(strict_types=1);

namespace Pingen\Models;

use Pingen\Models\General\DetailsItemMeta;
use Pingen\Models\General\ItemLinks;
use Pingen\Support\DataTransferObject;

/**
 * Class UserAssociationDetailsData
 * @package Pingen\Models
 */
class UserAssociationDetailsData extends DataTransferObject
{
    public ?string $id;

    public ?string $type;

    public ?UserAssociationItemAttributes $attributes;

    public ?UserAssociationRelationships $relationships;

    public ?ItemLinks $links;

    public ?DetailsItemMeta $meta;
}
