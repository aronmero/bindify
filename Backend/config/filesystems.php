<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],
        'avatars' => [
            'driver' => 'local',
            'root' => storage_path('app/public/avatars'), // Directorio donde se almacenarán los avatares
            'url' => env('APP_URL').'/storage', // URL base para acceder a los avatares
            'visibility' => 'public',
        ],
        'banners' => [
            'driver' => 'local',
            'root' => storage_path('app/public/banners'), // Directorio donde se almacenarán los banners
            'url' => env('APP_URL').'/storage', // URL base para acceder a los banners
            'visibility' => 'public',
        ],
        'posts' => [
            'driver' => 'local',
            'root' => storage_path('app/public/posts'), // Directorio donde se almacenarán los posts
            'url' => env('APP_URL').'/storage', // URL base para acceder a los posts
            'visibility' => 'public',
        ],
        'reviews' => [
            'driver' => 'local',
            'root' => storage_path('app/public/reviews'), // Directorio donde se almacenarán las reviews
            'url' => env('APP_URL').'/storage', // URL base para acceder a los reviews
            'visibility' => 'public',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
