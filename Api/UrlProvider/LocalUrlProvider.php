<?php

namespace Everlution\FileJetBundle\Api\UrlProvider;

use Everlution\FileJetBundle\Api\Common\IdentifiableFile;
use Everlution\FileJetBundle\Api\UrlProvider;
use Everlution\FileJetBundle\Storage\Storages;

class LocalUrlProvider implements UrlProvider
{
    private $storages;

    public function __construct(Storages $storages)
    {
        $this->storages = $storages;
    }

    public function getPublicUrl(IdentifiableFile $file): string
    {
        $publicUrl = $this->storages->getByName($file->getFileStorageName())->getPublicUrl();

        return "{$publicUrl}/{$file->getFileIdentifier()}";
    }

    public function getPublicMutatedUrl(IdentifiableFile $file, string $mutation, int $ttl = null): string
    {
        $publicUrl = $this->storages->getByName($file->getFileStorageName())->getPublicUrl();
        $filename = basename($file->getFileIdentifier());
        $ttlParameter = $ttl ? "?ttl=$ttl" : "";

        return "{$publicUrl}/mutated/{$file->getFileIdentifier()}/$mutation/{$filename}{$ttlParameter}";
    }
}
