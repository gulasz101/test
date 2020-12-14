<?php

declare(strict_types=1);

namespace Pingen\Models\General;

use Pingen\Support\DataTransferObject;

/**
 * Class RelationshipRelatedItemData
 * @package Pingen\Models\General
 */
class RelationshipRelatedItemData extends DataTransferObject
{
    public string $id;

    public string $type;
}
