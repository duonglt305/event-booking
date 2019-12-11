<?php


namespace DG\Dissertation\Admin\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * @var string
     */
    private $storagePath;

    /**
     * UploadImageService constructor.
     * @param string $storagePath
     */
    public function __construct(string $storagePath)
    {
        $this->storagePath = $storagePath;
    }

    /**
     * @return string
     */
    protected function getOrganizerPath()
    {
        return rtrim($this->storagePath, '/') . '/' . auth()->user()->slug;
    }

    /**
     * @param string $path
     * @return string
     */
    protected function getStoragePath($path = '')
    {
        $path = rtrim(ltrim($path, '/'), '/');
        return $this->getOrganizerPath() . '/' . $path;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param $name
     * @return string
     */
    protected function getUniqueImageName(UploadedFile $uploadedFile, $name)
    {
        return strtolower(\Str::random(16)) . '-' . $name . '.' . $uploadedFile->getClientOriginalExtension();
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $path
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    protected function upload(UploadedFile $uploadedFile, string $path, string $name)
    {
        $imageName = $this->getUniqueImageName($uploadedFile, $name);
        $image = $uploadedFile->move($path, $imageName);
        return $image;
    }

    /**
     * @param string $path
     */
    public function delete(string $path)
    {
        if (\File::exists(public_path($path))) {
            \File::delete(public_path($path));
        }
    }

}
