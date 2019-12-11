<?php

namespace DG\Dissertation\Admin\Services;

use Illuminate\Http\UploadedFile;

class SpeakerImageService extends ImageService
{
    /**
     * SpeakerImageService constructor.
     * @param string $storagePath
     */
    public function __construct(string $storagePath = 'storage')
    {
        parent::__construct($storagePath);
    }

    /**
     * @param string $path
     * @return string
     */
    protected function getStoragePath($path = '')
    {
        return parent::getStoragePath($path);
    }

    /**
     * @return string
     */
    protected function getOrganizerPath()
    {
        return parent::getOrganizerPath();
    }

    /**
     * @param $eventId
     * @return string
     */
    public function getSpeakerPath($eventId): string
    {
        return ltrim($this->getOrganizerPath(), '/') . DIRECTORY_SEPARATOR . $eventId . DIRECTORY_SEPARATOR . 'speaker';
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $name
     * @param string $eventId
     * @param null $width
     * @param null $height
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function upload(UploadedFile $uploadedFile, string $name, $eventId, $width = null, $height = null)
    {
        $image = parent::upload($uploadedFile, $this->getSpeakerPath($eventId), $name);
        if (!is_null($width) && !is_null($height)) {
            $imageResize = \Image::make($image);
            $imageResize->resize($width, $height);
            $imageResize->save($image);
        }
        return $image;
    }

}
