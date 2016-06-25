<?php

namespace LiveCMS\Support\Thumbnailer;

use Intervention\Image\ImageManager;
use LiveCMS\Support\File\File as FileSystem;

class ImageFile extends FileSystem
{
    protected $image;

    public function __contruct($path, ImageManager $image)
    {
        $this->image = $image;
        
        parent::__contruct($path);
    }

    public function __call($method, $arguments)
    {
        if (method_exists($image = $this->image->make($this), $method)) {

            $args = array_shift(func_get_args());

            call_user_func_array(array($image, $method), $args);
        }
    }
}
