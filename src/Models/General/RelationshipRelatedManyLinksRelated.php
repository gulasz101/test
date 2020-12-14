<?php

declare(strict_types=1);

namespace Pingen\Models\General;

use Pingen\Support\DataTransferObject;

/**
 * Class RelationshipRelatedManyLinksRelated
 * @package Pingen\Models\General
 */
class RelationshipRelatedManyLinksRelated extends DataTransferObject
{
    public ?string $href;

    public ?RelationshipRelatedManyLinksRelatedMeta $meta;
}
