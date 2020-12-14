<?php

declare(strict_types=1);

namespace Pingen\Models;

use Carbon\CarbonImmutable;
use Pingen\Support\DataTransferObject;

/**
 * Class UserAssociationItemAttributes
 * @package Pingen\Models
 */
class UserAssociationItemAttributes extends DataTransferObject
{
    public string $role;

    public string $status;

    public CarbonImmutable $created_at;

    public CarbonImmutable $updated_at;
}
