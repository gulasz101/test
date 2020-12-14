<?php

declare(strict_types=1);

namespace Pingen\Models;

use Pingen\Models\General\CollectionLinks;
use Pingen\Models\General\CollectionMeta;
use Pingen\Support\DataTransferObject;

/**
 * Class UserAssociationsCollection
 * @package Pingen\Models
 */
class UserAssociationsCollection extends DataTransferObject
{
    /**
     * @var \Pingen\Models\UserAssociationItem[]
     */
    public array $data;

    public CollectionLinks $links;

    public CollectionMeta $meta;

    /**
     * @var \Pingen\Models\CompanyItem[]|null
     */
    public ?array $included;
}
