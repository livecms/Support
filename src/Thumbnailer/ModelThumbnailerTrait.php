<?php

namespace LiveCMS\Support\Thumbnailer;

use Image;
use Thumb;

/**
 * HOW TO USE
 * insert trait to whenever model
 * or you can specify the default width and height in your base model
 *
 *
 * protected defWidth = 480 // landscape
 * protected defHeight = 360 // portrait
 * protected $thumbnailStyle = ['small_square' => '128x128', 'medium_square' => '256x256',
 * 'large_square' => '512x512', 'small_cover' => '240x_', 'medium_cover' => '480x_', 'large_cover' => '1024x_'];
 * protected imageAtrributes = ['your_image', ...]
 * protected defThumbnail = '_thumbnail'
 * protected baseFolder = 'public/uploads'
 */

trait ModelThumbnailerTrait
{
    protected static $oldThumbnail;

    protected $imageAttributes = [];

    // every images must created the thumbnail
    public static function bootThumbnailerTrait()
    {
        static::saving(function ($model) {
            $model::$oldThumbnail = $model->getOriginal();
        });
        static::saved(function ($model) {
            $model->makeThumbnail();
        });
        static::deleted(function ($model) {
            $model->deleteThumbnails();
        });
    }

    public function toArray()
    {
        $array = array_merge(parent::toArray(), $this->getThumbnailArray());

        return $array;
    }

    public function getAttribute($key)
    {
        $array = $this->getThumbnailArray();

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        
        $get = parent::getAttribute($key);
        
        if ($get != null) {
            return $get;
        }

        return null;
    }

    public function deleteThumbnails()
    {
        $originals = $this->getOriginal();

        foreach ($this->getImageAttributes() as $attribute => $folder) {
            
            if (!isset($originals[$attribute])) {
                continue;
            }

            $image = $this->getImagePath($attribute);

            @unlink($image);

            $this->deleteThumbnailFromImage($image);

        }
    }

    public function deleteThumbnailFromImage($filepath)
    {
        // read style
        foreach (array_merge($this->getThumbnailStyle(), [app('thumbnailer')->getDefThumbnailName() => '']) as $value) {
            @unlink($this->locateThumbnail($filepath, $value));
        }
    }

    protected function getThumbnailStyle()
    {
        return property_exists($this, 'thumbnailStyle') ? $this->thumbnailStyle : [];
    }

    /**
     * Determines if an array is associative.
     *
     * An array is "associative" if it doesn't have sequential numerical keys beginning with zero.
     *
     * @param  array  $array
     * @return bool
     */
    public function isAssoc(array $array)
    {
        $keys = array_keys($array);

        return array_keys($keys) !== $keys;
    }

    protected function getImageFolder($attribute)
    {
        $imageAttributes = $this->images;
        $folder = !$this->isAssoc($imageAttributes) ? '' :
            (isset($imageAttributes[$attribute]) ? $imageAttributes[$attribute] : '');
        
        return $folder;
    }

    public function getImagePath($attribute, $file = null)
    {
        if ($file == null) {
            $file = isset($this->attributes[$attribute]) ? $this->attributes[$attribute] : '';
        }

        $baseFolder = property_exists($this, 'baseFolder') ? $this->baseFolder : app('uploader')->getBaseFolder();

        $imageFolder = ($folder = $this->getImageFolder($attribute)) != '' ? DIRECTORY_SEPARATOR.$folder : $folder;

        return base_path($baseFolder.$imageFolder.DIRECTORY_SEPARATOR.$file);
    }

    protected function getImageAttributes()
    {
        $imageAttributes = $this->images;

        if (!$this->isAssoc($imageAttributes)) {
            $imageAttributes = array_flip($imageAttributes);
        }

        return $imageAttributes;
    }

    public function makeThumbnail()
    {
        foreach ($this->getImageAttributes() as $attribute => $folder) {
            
            if (!$this->getAttributeValue($attribute)) {
                continue;
            }

            $this->generateThumbnail($attribute);
        }
    }

    protected function getThumbnailName($file, $size = '')
    {
        return pathinfo(basename($file), PATHINFO_FILENAME).app('thumbnailer')->getDefThumbnailName().$size;
    }

    protected function getExtension($file)
    {
        return pathinfo(basename($file), PATHINFO_EXTENSION);
    }

    protected function generateThumbnail($attribute, $size = null)
    {
        $savedOldThumbnail = isset(static::$oldThumbnail[$attribute]) ? static::$oldThumbnail[$attribute] : null;

        $imagePath = $this->getImagePath($attribute);

        $oldThumbnail = $this->getImagePath($attribute, $savedOldThumbnail);

        if (!file_exists($oldThumbnail) || $this->isDirty($attribute)) {

            @unlink($oldThumbnail);

            $this->deleteThumbnailFromImage($oldThumbnail);
        }


        if (!file_exists($imagePath)) {
            return;
        }

        $defSize = property_exists($this, 'size') ? $this->size : app('thumbnailer')->getSize();

        // set default thumbnail
        $size = $size ?: $defSize;

        $thumbnail = $this->getThumbnailName($imagePath); // file._thumbnail

        Thumb::make($imagePath, $size)->rename($thumbnail);

        // read style
        foreach ($this->getThumbnailStyle() as $size) {
            $name = $this->getThumbnailName($imagePath, $size);
            Thumb::make($imagePath, $size)->rename($name);
        }
    }

    /**
     * Make Location toThumbnail
     * @param  string $imagePath real path
     * @param  string $width     width
     * @param  string $height    height
     * @return string            real path of thumbnail
     */
    protected function locateThumbnail($imagePath = '', $size = '')
    {
        $expl = explode('.', $imagePath);
        $extension = array_pop($expl);

        $thumbnail = implode('.', $expl). app('thumbnailer')->getDefThumbnailName() . $size .'.'. $extension;

        return $thumbnail;
    }
    
    // make a function to access the thumbnail

    public function getThumbnailArray()
    {
        $array = [];


        foreach ($this->images as $attribute => $imageDir) {
            
            if (is_numeric($attribute)) {
                $attribute = $imageDir;
                $imageDir = '';
            }
            
            $imagePath = $this->getImagePath($attribute);
            
            $array[$attribute] = url(substr($imagePath, strlen(public_path())));
            
            if (!file_exists($imagePath)) {
                continue;
            }

            $style = array_merge($this->getThumbnailStyle(), [ltrim(app('thumbnailer')->getDefThumbnailName(), '_') => null]);

            foreach ($style as $name => $size) {

                $attributeName = str_replace('_url', '', $attribute).'_'.$name;

                if (!isset($this->attributes[$attribute]) || $this->attributes[$attribute] == null) {
                    $array[$attributeName] = null;
                    continue;
                }
                
                
                $thumbnail = $this->locateThumbnail($imagePath, $size);

                if (!file_exists($thumbnail)) {
                    $this->generateThumbnail($attribute, $size);
                }

                $array[$attributeName] = url(substr($thumbnail, strlen(public_path())));
            }

        }

        return $array;
    }
}
