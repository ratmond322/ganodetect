<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "ably", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        'pusher' => [
        'driver' => 'pusher',
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            // cluster tetap dipakai untuk Pusher cloud; tidak berpengaruh jika host override
            'cluster' => env('PUSHER_APP_CLUSTER', 'mt1'),

            // host/port/scheme untuk laravel-websockets lokal
            'host' => env('PUSHER_HOST', '127.0.0.1'),
            'port' => env('PUSHER_PORT', 6001),
            'scheme' => env('PUSHER_SCHEME', 'http'),

            // jika kamu menggunakan TLS (wss/https), set useTLS true dan scheme https
            'useTLS' => env('PUSHER_USE_TLS', false),

            // some local setups need this to false; for cloud keep true
            'encrypted' => env('PUSHER_ENCRYPTED', false),

            // disable stats - optional
            'curl_options' => [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ],
        ],
        'client_options' => [
            // Guzzle client options if you need them
        ],
    ],


    ],

];
