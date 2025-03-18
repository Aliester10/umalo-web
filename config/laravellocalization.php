<?php

return [

    // Uncomment the languages that your site supports - or add new ones.
    // These are sorted by the native name, which is the order you might show them in a language selector.
    // Regional languages are sorted by their base language, so "British English" sorts as "English, British"
    'supportedLocales' => [
        'id'          => ['name' => 'Indonesian',             'script' => 'Latn', 'native' => 'Bahasa Indonesia', 'regional' => 'id_ID'],
        'en'          => ['name' => 'English',                'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    ],
    'useAcceptLanguageHeader' => true,
    'hideDefaultLocaleInURL' => false,
    'localesOrder' => [],
    'localesMapping' => [],
    'utf8suffix' => env('LARAVELLOCALIZATION_UTF8SUFFIX', '.UTF-8'),
    'urlsIgnored' => ['/skipped'],

    'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE'],
];
