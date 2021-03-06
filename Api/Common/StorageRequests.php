<?php

namespace Everlution\FileJetBundle\Api\Common;

use Everlution\FileJetBundle\Http\Request\Request;
use Everlution\FileJetBundle\Storage\Storage;

trait StorageRequests
{
    /**
     * @param Request $request
     * @param Storage $storage
     * @return Request
     */
    protected function toStorageRequest(Request $request, Storage $storage)
    {
        $relativePath = $request->getUrl();
        $url = $storage->getApiUrl() . '/' . $storage->getId() . $relativePath;

        $headers = $request->getHeaders();
        $headers['Authorization'] = [$storage->getApiKey()];

        return $request->setUrl($url)->setHeaders($headers);
    }
}
