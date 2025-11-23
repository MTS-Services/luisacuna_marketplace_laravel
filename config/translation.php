<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Translation Auto-Translate
    |--------------------------------------------------------------------------
    |
    | This option enables or disables automatic translation of model fields
    | when using the HasTranslations trait. If set to true, translation jobs
    | will be dispatched automatically.
    |
    */

    'auto_translate' => env('AUTO_TRANSLATE', false),

    'deepl' => [
        'key' => env('DEEPL_API_KEY'),
        'is_free' => env('DEEPL_API_FREE', false),
    ],

];
