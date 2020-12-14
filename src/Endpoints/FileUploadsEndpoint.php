<?php

declare(strict_types=1);

namespace Pingen\Endpoints;

use Illuminate\Http\Client\Factory;
use Pingen\Endpoint;
use Pingen\Models\FileUpload\FileUploadDetails;

/**
 * Class FileUploadsEndpoint
 * @package Pingen\Endpoints
 */
class FileUploadsEndpoint extends Endpoint
{
    /**
     * @return FileUploadDetails
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getDetails(): FileUploadDetails
    {
        return new FileUploadDetails(
            $this
                ->performGetDetailsRequest('/file-upload')
                ->json()
        );
    }

    /**
     * @param FileUploadDetails $details
     * @param resource|string $file You can pass here resource, string with path or file contents.
     * @throws \Illuminate\Http\Client\RequestException
     * @throws \InvalidArgumentException In case url is expired or file cannot be processed.
     */
    public function uploadFile(FileUploadDetails $details, $file): void
    {
        if ($details->data->attributes->expires_at->isPast()) {
            throw new \InvalidArgumentException('Url expired.');
        }

        $fileToUpload = tmpfile();
        switch (true) {
            case is_resource($file):
                stream_copy_to_stream($file, $fileToUpload);
                break;
            case is_file($file):
                $tmp = fopen($file, 'r');
                stream_copy_to_stream($tmp, $fileToUpload);
                fclose($tmp);
                break;
            case is_string($file):
                fwrite($fileToUpload, $file);
                break;
            default:
                throw new \InvalidArgumentException('Invalid file parameter.');
        }

        (new Factory())
            ->withOptions(['body' => $fileToUpload])
            ->put($details->data->attributes->url)
            ->throw();
    }
}
