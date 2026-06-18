<?php

return [
    'enabled' => filter_var(env('FIREBASE_ENABLED', false), FILTER_VALIDATE_BOOL),

    'project_id' => env('FIREBASE_PROJECT_ID', 'buatin-id-34ac3'),
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', 'buatin-id-34ac3.firebasestorage.app'),
    'database' => env('FIREBASE_FIRESTORE_DATABASE', '(default)'),

    /*
    |--------------------------------------------------------------------------
    | Firebase Web App config (client-side Authentication)
    |--------------------------------------------------------------------------
    |
    | These values are public by design (shipped to the browser) and power
    | Firebase Authentication on the login/register pages.
    |
    */
    'web' => [
        'apiKey' => env('FIREBASE_WEB_API_KEY', 'AIzaSyAByYiIUbgJns_DkKkfkxV47RFYmJNqKd0'),
        'authDomain' => env('FIREBASE_WEB_AUTH_DOMAIN', 'buatin-id-34ac3.firebaseapp.com'),
        'projectId' => env('FIREBASE_PROJECT_ID', 'buatin-id-34ac3'),
        'storageBucket' => env('FIREBASE_STORAGE_BUCKET', 'buatin-id-34ac3.firebasestorage.app'),
        'messagingSenderId' => env('FIREBASE_WEB_SENDER_ID', '785245752228'),
        'appId' => env('FIREBASE_WEB_APP_ID', '1:785245752228:web:d50ef6d02927a996dc4f31'),
    ],

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
