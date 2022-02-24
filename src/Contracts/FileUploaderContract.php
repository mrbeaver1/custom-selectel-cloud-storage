<?php

namespace MrBeaver1\Selectel\CloudStorage\Contracts;

use MrBeaver1\Selectel\CloudStorage\Contracts\Api\ApiClientContract;

interface FileUploaderContract
{
    /**
     * Upload file from string or stream resource.
     *
     * @param \MrBeaver1\Selectel\CloudStorage\Contracts\Api\ApiClientContract $api
     * @param string                                                               $path           Remote path.
     * @param string|resource                                                      $body           File contents.
     * @param array                                                                $params         = [] Upload params.
     * @param bool                                                                 $verifyChecksum = true
     *
     * @throws \MrBeaver1\Selectel\CloudStorage\Exceptions\UploadFailedException
     *
     * @return string
     */
    public function upload(ApiClientContract $api, $path, $body, array $params = [], $verifyChecksum = true);
}
