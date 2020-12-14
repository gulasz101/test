<?php

declare(strict_types=1);

namespace Pingen\Models\FileUpload;

use Carbon\CarbonImmutable;
use Pingen\Support\DataTransferObject;

/**
 * Class FileUploadItemAttributes
 * @package Pingen\Models\FileUpload
 */
class FileUploadItemAttributes extends DataTransferObject
{
    public string $url;

    public string $url_signature;

    public CarbonImmutable $expires_at;
}
