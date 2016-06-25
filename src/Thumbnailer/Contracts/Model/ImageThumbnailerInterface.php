<?php

namespace LiveCMS\Support\Thumbnailer\Contracts\Model;

interface ImageThumbnailerInterface
{
    public function deleteThumbnailFromImage($filepath);

    public function makeThumbnail();

    public function getThumbnailArray();
}
