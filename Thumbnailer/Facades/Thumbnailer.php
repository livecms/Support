<?php

namespace LiveCMS\Support\Thumbnailer\Facades;

class Thumbnailer extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'thumbnailer';
    }
}
