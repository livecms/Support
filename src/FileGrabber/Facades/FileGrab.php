<?php

namespace LiveCMS\Support\FileGrabber\Facades;

class FileGrab extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'filegrabber';
    }
}
