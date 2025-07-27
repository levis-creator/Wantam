<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | This option controls the default filesystem disk that will be used by
    | the framework. You can set it in your .env file via FILESYSTEM_DISK.
    | The default is "public" for serving files like images, CSS, etc.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | You can configure multiple disks for different storage needs.
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    | - local: for internal use (e.g., logs, private documents)
    | - public: for assets accessible via URL (e.g., images)
    | - s3: cloud-based storage (e.g., Amazon S3)
    |
    */

    'disks' => [

        // Private local disk (not web-accessible)
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'visibility' => 'private',
            'throw' => false,
        ],

        // Public disk used for storing and serving user-facing files
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage', // Enables Storage::url()
            'visibility' => 'public',
            'throw' => false,
        ],

        // Amazon S3 disk for cloud storage
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
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | When you run `php artisan storage:link`, Laravel will create symbolic
    | links from public paths to storage paths to serve public files.
    |
    | Ensure the `public` disk above points to `app/public`.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],
];
