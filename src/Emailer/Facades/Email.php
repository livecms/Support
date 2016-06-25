<?php

namespace LiveCMS\Support\Emailer\Facades;

class Email extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'emailer';
    }
}
