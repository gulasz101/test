<?php

declare(strict_types=1);

namespace Pingen\Models\General;

/**
 * Class RelationshipRelatedMany
 * @package Pingen\Models\General
 */
class RelationshipRelatedMany extends \Pingen\Support\DataTransferObject
{
    public ?RelationshipRelatedManyLinks $links;
}
