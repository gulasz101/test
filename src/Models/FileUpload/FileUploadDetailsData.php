<?php

declare(strict_types=1);

namespace Pingen\Models\FileUpload;

use Pingen\Support\DataTransferObject;

/**
 * Class FileUploadDetailsData
 * @package Pingen\Models\FileUpload
 */
class FileUploadDetailsData extends DataTransferObject
{
    public string $type;

    public string $id;

    public FileUploadItemAttributes $attributes;
}
