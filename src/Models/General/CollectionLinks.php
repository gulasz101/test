<?php

declare(strict_types=1);

namespace Pingen\Models\General;

use Pingen\Support\DataTransferObject;

/**
 * Class CollectionLinks
 * @package Pingen\Models\General
 */
class CollectionLinks extends DataTransferObject
{
    public string $first;

    public string $last;

    public ?string $prev;

    public ?string $next;

    public string $self;
}
