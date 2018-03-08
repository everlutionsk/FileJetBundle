<?php

namespace Everlution\FileJetBundle\Storage;

class Storage
{
    private $id;
    private $apiKey;
    private $name;
    private $publicUrl;

    public function __construct(string $id, string $apiKey, string $name, string $publicUrl)
    {
        $this->id = $id;
        $this->apiKey = $apiKey;
        $this->name = $name;
        $this->publicUrl = $publicUrl;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPublicUrl(): string
    {
        return $this->publicUrl;
    }

    public function getApiUrl(): string
    {
        return 'https://sm.filejet.io/storage/v1';
    }
}
