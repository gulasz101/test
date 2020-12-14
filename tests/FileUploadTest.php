<?php

declare(strict_types=1);

namespace Tests;

use Carbon\Carbon;
use Pingen\Endpoints\FileUploadsEndpoint;
use Pingen\Models\FileUpload\FileUploadDetails;

/**
 * Class FileUploadTest
 * @package Tests
 */
class FileUploadTest extends DummyTest
{
    public function testUploadUrlExpired(): void
    {
        $this->expectErrorMessage('Url expired.');

        $endpoint = new FileUploadsEndpoint($this->provider);

        $endpoint->uploadFile(
            new FileUploadDetails(
                array(
                    'data' => array(
                        'id' => 'id',
                        'type' => 'file_uploads',
                        'attributes' => array(
                            'url' => 'http://s3.local',
                            'url_signature' => 'superhashedstring',
                            'expires_at' => Carbon::now()->subMinute(),
                        ),
                    ),
                )
            ),
            'lorem ipsum'
        );
    }
}
