<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Vasara Driver
    |--------------------------------------------------------------------------
    |
    | This is option to change driver, use postman as default
    |
    | The available driver are "postman"
    |
    */

    'driver' => env('VASARA_DRIVER', 'postman'),

    /*
    |--------------------------------------------------------------------------
    | Vasara Host
    |--------------------------------------------------------------------------
    |
    | This is option to change host to all main url exist in REST API
    |
    */

    'host' => env('VASARA_HOST', 'http://localhost'),
];