<?php

return [

    'supported_locales' => [
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_US'],
        'ru' => ['name' => 'Russian', 'script' => 'Cyrl', 'native' => 'Русский', 'regional' => 'ru_RU'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Locales
    |--------------------------------------------------------------------------
    |
    | Contains an array with the applications available locales.
    |
    */
    'locales' => [
        'en',
        'ru',
    ],

    /*
    |--------------------------------------------------------------------------
    | Locale separator
    |--------------------------------------------------------------------------
    |
    | This is a string used to glue the language and the country when defining
    | the available locales. Example: if set to '-', then the locale for
    | colombian spanish will be saved as 'es-CO' into the database.
    |
    */
    'locale_separator' => '-',

    /*
    |--------------------------------------------------------------------------
    | Default locale
    |--------------------------------------------------------------------------
    |
    | As a default locale, Translatable takes the locale of Laravel's
    | translator. If for some reason you want to override this,
    | you can specify what default should be used here.
    |
    */
//    'locale' => 'en',
	'locale' => null,

    /*
    |--------------------------------------------------------------------------
    | Use fallback
    |--------------------------------------------------------------------------
    |
    | Determine if fallback locales are returned by default or not. To add
    | more flexibility and configure this option per "translatable"
    | instance, this value will be overridden by the property
    | $useTranslationFallback when defined
    |
    */
    'use_fallback' => true,

    /*
    |--------------------------------------------------------------------------
    | Fallback Locale
    |--------------------------------------------------------------------------
    |
    | A fallback locale is the locale being used to return a translation
    | when the requested translation is not existing. To disable it
    | set it to false.
    |
    */
    'fallback_locale' => 'ru',

    /*
    |--------------------------------------------------------------------------
    | Translation Suffix
    |--------------------------------------------------------------------------
    |
    | Defines the default 'Translate' class suffix. For example, if
    | you want to use CountryTrans instead of CountryTranslate
    | application, set this to 'Trans'.
    |
    */
    'translation_suffix' => 'Translate',

    /*
    |--------------------------------------------------------------------------
    | Locale key
    |--------------------------------------------------------------------------
    |
    | Defines the 'locale' field name, which is used by the
    | translation model.
    |
    */
    'locale_key' => 'locale',



];
