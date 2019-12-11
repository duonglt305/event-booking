<?php


namespace DG\Dissertation\Admin\Services;


use Illuminate\Http\UploadedFile;

class ArticleImageService extends ImageService
{
    public function __construct(string $storagePath = 'storage')
    {
        parent::__construct($storagePath);
    }

    /**
     * @param $eventId
     * @return string
     */
    public function getArticlePath($eventId)
    {
        return rtrim(parent::getOrganizerPath(), '') . DIRECTORY_SEPARATOR . $eventId . DIRECTORY_SEPARATOR . 'articles';
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
        $image = parent::upload($uploadedFile, $this->getArticlePath($eventId), $name);

        if (!is_null($width) && !is_null($height)) {
            $imageResize = \Image::make($image);
            $imageResize->resize($width, $height);
            $imageResize->save($image);
        }
        return $image;
    }

}
