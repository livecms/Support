<?php

return [

    'thumbnailer' => [

        // 'thumb' => '_thumb_',

        // 'size' => '300x300',
    ],

    'uploader' => [
        
        // 'override' => false,

        // 'modelOverride' => true,

        // 'baseFolder' => 'public/uploads',

        // 'folder' => '',

    ],

    'emailer' => [

        'from' => [
            'address' => env('EMAIL_ADDRESS', null),
            'name' => env('EMAIL_NAME', null),
        ],
        'subject' => 'Hello',
        'siteurl' => env('SITE_URL', env('APP_URL')),
        'sitename' => env('SITE_NAME', null),
        'siteslogan' => env('SITE_SLOGAN', null),

        'activation' => ['subject' => 'Account Activation'],

        'welcome' => [],

        'alert' => ['parent' => 'welcome', 'subject' => 'alert'],
    
        'invoice' => [],
    ],

];
