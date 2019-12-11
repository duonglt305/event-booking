<?php


namespace DG\Dissertation\Admin\Services;


use Illuminate\Http\UploadedFile;

class PartnerImageServices extends ImageService
{
    public function __construct(string $storagePath = 'storage')
    {
        parent::__construct($storagePath);
    }

    public function getPartnerPath($eventId)
    {
        return rtrim(parent::getOrganizerPath(), '/') . DIRECTORY_SEPARATOR . $eventId . DIRECTORY_SEPARATOR . 'partner';
    }

    public function upload(UploadedFile $uploadedFile, string $name, $eventId, $width = null, $height = null)
    {
        $image = parent::upload($uploadedFile, $this->getPartnerPath($eventId), $name);
        if (!is_null($width) && !is_null($height)) {
            $imageResize = \Image::make($image);
            $imageResize->resize($width, $height);
            $imageResize->save($image);
        }
        return $image;
    }
}
