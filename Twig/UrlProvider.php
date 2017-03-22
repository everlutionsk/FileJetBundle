<?php

namespace Everlution\FileJetBundle\Twig;

use Everlution\FileJetBundle\Api\Common\IdentifiableFile;
use Everlution\FileJetBundle\Api\UrlProvider as UrlProviderApi;
use Everlution\FileJetBundle\Entity\File;

class UrlProvider extends \Twig_Extension
{
    /** @var UrlProviderApi */
    protected $api;

    /**
     * @param UrlProviderApi $api
     */
    public function __construct(UrlProviderApi $api)
    {
        $this->api = $api;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return \Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('file_url', array($this, 'generateFileUrl')),
            new \Twig_SimpleFunction('origin_file_url', array($this, 'generateOriginFileUrl')),
        ];
    }

    /**
     * @param $file
     * @param string|null $mutation
     * @param int|null $ttl
     * @return string
     */
    public function generateFileUrl($file, $mutation = null, $ttl = null)
    {
        $file = $this->normalizeFile($file);
        $predefinedMutation = $file->getFileMutation();

        if ($predefinedMutation !== null) {
            if ($mutation === null) {
                $mutation = $predefinedMutation;
            } else {
                $mutation = "$predefinedMutation,$mutation";
            }
        }

        return $this->generateUrl($file, $mutation, $ttl);
    }

    /**
     * @param IdentifiableFile $file
     * @param string|null $mutation
     * @param string|null $ttl
     * @return string
     */
    public function generateOriginFileUrl(IdentifiableFile $file, $mutation = null, $ttl = null)
    {
        return $this->generateUrl($file, $mutation, $ttl);
    }

    /**
     * @param IdentifiableFile $file
     * @param string|null $mutation
     * @param string|null $ttl
     * @return string
     */
    protected function generateUrl(IdentifiableFile $file, $mutation = null, $ttl = null)
    {
        if ($mutation === null) {
            return $this->api->getPublicUrl($file);
        } else {
            return  $this->api->getPublicMutatedUrl($file, $mutation, $ttl);
        }
    }

    /**
     * @param $file
     * @return File
     * @throws \Exception
     */
    private function normalizeFile($file)
    {
        if ($file instanceof File) {
            return $file;
        }

        if (is_array($file)) {
            if (array_key_exists('fileIdentifier', $file) === false ||
                array_key_exists('fileStorageName', $file) === false ||
                array_key_exists('fileMutation', $file) === false) {

                $newFile = new File();
                $newFile->setFile(
                    $file['fileIdentifier'],
                    $file['fileStorageName'],
                    $file['fileMutation']
                );

                return $file;
            }
        }

        throw new \Exception('Invalid file given');
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'file_jet_bundle_url_provider';
    }
}
