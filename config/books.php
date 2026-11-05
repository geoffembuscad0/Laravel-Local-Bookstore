<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Book Cover Storage
    |--------------------------------------------------------------------------
    |
    | Supported disks:
    | - public (local development)
    | - s3 (future production storage)
    |
    */
    'cover_disk' => env('BOOK_COVER_DISK', 'public'),
    'cover_directory' => 'books/covers',
];