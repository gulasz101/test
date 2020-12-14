<?php

declare(strict_types=1);

namespace Pingen\Models;

use Pingen\Models\General\ItemLinks;
use Pingen\Models\General\RelationshipRelatedMany;
use Pingen\Support\DataTransferObject;

/**
 * Class CompanyItem
 * @package Pingen\Models
 */
class CompanyItem extends DataTransferObject
{
    public ?string $id;

    public string $type = 'companies';

    public CompanyItemAttributes $attributes;

    public ?RelationshipRelatedMany $relationships;

    public ?ItemLinks $links;

    public static function makeForPost(): self
    {
        return new self(array(
            'attributes' => array(),
        ));
    }
}
