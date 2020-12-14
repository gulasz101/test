<?php

declare(strict_types=1);

namespace Pingen\Models\General;

use Pingen\Support\DataTransferObject;

/**
 * Class RelationshipRelatedItem
 * @package Pingen\Models\General
 */
class RelationshipRelatedItem extends DataTransferObject
{
    public RelationshipRelatedItemLinks $links;

    public RelationshipRelatedItemData $data;
}
