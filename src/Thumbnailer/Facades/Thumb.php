<?php

namespace LiveCMS\Support\Thumbnailer\Facades;

class Thumb extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'thumbnailer';
    }
}
