<?php

declare(strict_types=1);

namespace Pingen\Models\General;

use Pingen\Support\DataTransferObject;

/**
 * Class RelationshipRelatedManyLinks
 * @package Pingen\Models\General
 */
class RelationshipRelatedManyLinks extends DataTransferObject
{
    public ?RelationshipRelatedManyLinksRelated $related;
}
