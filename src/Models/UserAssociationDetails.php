<?php

declare(strict_types=1);

namespace Pingen\Models;

use Pingen\Support\DataTransferObject;

/**
 * Class UserAssociationDetails
 * @package Pingen\Models
 */
class UserAssociationDetails extends DataTransferObject
{
    public ?UserAssociationDetailsData $data;
}
