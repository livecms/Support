<?php

namespace LiveCMS\Support\Uploader;

use LiveCMS\Support\File\File as FileSystem;
use LiveCMS\Support\Uploader\Upload as Uploader;

class File extends FileSystem
{
    protected $uploader;

    public function __construct(Uploader $file)
    {
        $this->uploader = $file;

        parent::__construct($file->getFile());
    }

    /**
     * Get Uploader Property
     * @return Uploader obviously
     */
    public function getUploader()
    {
        return $this->uploader;
    }

    /**
     * Save to different disk
     * @param  string $disk local|s3|rackspace|etc
     * @param  string $path path/to/file
     * @return int
     */
    public function to($disk, $path = null)
    {
        $path = $path === null ? $this->uploader->getFolder().DIRECTORY_SEPARATOR.$this->getBasename() : $path;

        return parent::to($disk, $path);
    }
}
