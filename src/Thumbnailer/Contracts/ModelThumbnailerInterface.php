<?php

namespace LiveCMS\Support\Thumbnailer\Contracts;

interface ModelThumbnailerInterface
{
    public function deleteThumbnailFromImage($filepath);

    public function makeThumbnail();

    public function getThumbnailArray();
}
