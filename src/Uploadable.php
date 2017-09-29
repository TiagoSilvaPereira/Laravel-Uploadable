<?php

namespace KingOfCode\Uploadable;

use KingOfCode\Uploadable\Uploader;
use Illuminate\Database\Eloquent\Model;

trait Uploadable {

    /**
     * The images default width for resize (mantaining aspect ratio)
     * @var array
     */
    protected $imageDefaultSizes = [
        'thumb' => 100,
        'medium' => 300,
        'normal' => 'image_width'
    ];

    /**
     * Boot the Trait
     */
    public static function bootUploadable()
    {
        static::saving(function (Model $model) {
            $model->uploadFiles();
        });

        static::deleting(function (Model $model) {
            $model->deleteFiles();
        });
    }

    /**
     * Handle file upload.
     */
    public function uploadFiles()
    {
        (new Uploader($this))->uploadFiles();
    }
    /**
     * Handle file removal.
     */
    public function deleteFiles() {
        (new Uploader($this))->deleteFiles();
    }

    public function getImagePath($imageField, $type = 'normal')
    {
        return (new Uploader($this))->getImagePath($imageField, $type);
    }

    public function getFilePath($fileField)
    {
        return (new Uploader($this))->getFilePath($fileField);
    }

    /**
     * Get model image uploadable names
     */
    public function getUploadableImages() {
        return $this->uploadableImages;
    }

    /**
     * Get model file uploadable names
     */
    public function getUploadableFiles() {
        return $this->uploadableFiles;
    }

    /**
     * Get images default sizes
     */
    public function getImageDefaultSizes() {
        return $this->imageDefaultSizes;
    }

    /**
     * Get images default size types
     */
    public function getImageResizeTypes() {
        return $this->imageResizeTypes;
    }

}