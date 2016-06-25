<?php

namespace LiveCMS\Support\Thumbnailer;

use Intervention\Image\ImageManager;
use LiveCMS\Support\File\DummyFile;
use LiveCMS\Support\Thumbnailer\ImageFile;

class Thumbnailer
{
    protected static $image;

    protected $file;

    protected $prefix = '_thumb_';

    protected $size = '300x300';

    protected $defThumbnailName = '_thumbnail';
    
    protected $defWidth = 480;

    protected $defHeight = 360;

    public function __contruct($file = null, $config = [])
    {
        $this->file = $file;

        $this->with($config);
    }

    public function setImage(ImageManager $image)
    {
        static::$image = $image;
    }

    public function getImage()
    {
        return static::$image;
    }

    /**
     * Set config
     * @param  array  $config
     * @return $this
     */
    public function with($config = [])
    {
        $defaults = collect(get_object_vars($this))->except('file')->toArray();

        $configs = array_replace($defaults, $config);

        foreach ($configs as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    /**
     * Make Thubnail
     * @param  string  $file path/to/file|File
     * @param  string|array  $size     300x_|_x120|
     * @param  boolean $override delete and create a new one ?
     * @return File    Thumbnail
     */
    public function make($file, $size = null, $override = false)
    {
        $size = ($size == null) ? $this->size : $size;


        $this->file = new ImageFile($file, $this->getImage());

        $thumbSize = (array) $size;

        $thumbs = [];

        foreach ($thumbSize as $sz) {
            $thumbs[] = $this->thumb($sz, $override);
        }

        return !is_array($size) ? $thumbs[0] : collect($thumbs);

    }

    public function getDefThumbnailName()
    {
        return $this->defThumbnailName;
    }
    
    public function getDefWidth()
    {
        return $this->defWidth;
    }

    public function getDefHeight()
    {
        return $this->defHeight;
    }

    public function getSize()
    {
        return $this->size;
    }
    
    /**
     * Generate Thubnail
     * @param  string  $size     300x_|_x120|
     * @param  boolean $override delete and create a new one ?
     * @return File    Thumbnail
     */
    protected function thumb($size = null, $override = false)
    {
        // read the image
        try {
            
            $image = $this->getImage()->make($this->file);
        
        } catch (\Exception $e) {
            
            return new DummyFile;
        }

        $thumbnail = $this->locateThumbnail($size);

        if (file_exists($thumbnail)) {
            
            if (!$override) {
                return new ImageFile($thumbnail, $this->getImage());
            }
            
            @unlink($thumbnail);
        }
                
        $image->orientate();

        list($width, $height) = explode('x', $size);

        if (!is_numeric($width) && !is_numeric($height)) {

            return new ImageFile($this, $this->getImage()->file);
        }

        if (!is_numeric($width)) {

            $image->heighten($height)->save($thumbnail);
        
        } elseif (!is_numeric($height)) {
        
            $image->widen($width)->save($thumbnail);
        
        } else {
        
            $image->fit($width, $height)->save($thumbnail);
        }

        return new ImageFile($thumbnail, $this->getImage());
    }

    /**
     * Make Location toThumbnail
     * @param  string $imagePath real path
     * @param  string $width     width
     * @param  string $height    height
     * @return string            real path of thumbnail
     */
    protected function locateThumbnail($size)
    {
        $file = $this->file;

        $filename = pathinfo($file, PATHINFO_FILENAME); // file

        $extension = pathinfo($file, PATHINFO_EXTENSION); // jpg

        $thumbnail = $file->getPath().DIRECTORY_SEPARATOR.$filename. $this->prefix . $size .'.'. $extension;

        return $thumbnail;
    }
}
