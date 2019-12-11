<?php


namespace DG\Dissertation\Admin\Services;


use Illuminate\Http\UploadedFile;

class EventImageService extends ImageService
{
    /**
     * EventImageService constructor.
     * @param string $storagePath
     */
    public function __construct(string $storagePath = 'storage')
    {
        parent::__construct($storagePath);
    }

    /**
     * @return string
     */
    protected function getEventThumbnailPath(): string
    {
        return $this->getStoragePath('thumbnails');
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param $name
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function uploadEventThumbnail(UploadedFile $uploadedFile, $name)
    {
        $imagePath = $this->upload($uploadedFile, $this->getEventThumbnailPath(), $name);
        $image = \Image::make($imagePath);
        $image->resize(500, 300);
        $image->save($imagePath);
        return $imagePath;
    }

    public function delete(string $path)
    {
        parent::delete($path);
    }
}
