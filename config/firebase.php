<?php

return [
    'enabled' => filter_var(env('FIREBASE_ENABLED', false), FILTER_VALIDATE_BOOL),

    'project_id' => env('FIREBASE_PROJECT_ID', 'buatin-id-34ac3'),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', 'buatin-id-34ac3.firebasestorage.app'),
    'database' => env('FIREBASE_FIRESTORE_DATABASE', '(default)'),

    /*
    |--------------------------------------------------------------------------
    | Firebase service account
    |--------------------------------------------------------------------------
    |
    | Use only one of these in production:
    | - FIREBASE_CREDENTIALS_BASE64: base64 encoded service account JSON
    | - FIREBASE_CREDENTIALS_JSON: raw JSON string
    | - FIREBASE_CREDENTIALS_PATH: absolute path to service account JSON
    |
    */
    'credentials_base64' => env('FIREBASE_CREDENTIALS_BASE64'),
    'credentials_json' => env('FIREBASE_CREDENTIALS_JSON'),
    'credentials_path' => env('FIREBASE_CREDENTIALS_PATH'),
];
