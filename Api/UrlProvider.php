<?php

namespace Everlution\FileJetBundle\Api;

use Everlution\FileJetBundle\Api\Common\IdentifiableFile;

interface UrlProvider
{
    public function getPublicUrl(IdentifiableFile $file): string;

    public function getPublicMutatedUrl(IdentifiableFile $file, string $mutation, int $ttl = null): string;
}
