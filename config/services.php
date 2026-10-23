<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    // WhatsApp digest of Boula D's open tasks (php artisan tasks:whatsapp-digest)
    'whatsapp' => [
        // callmebot (free, personal number) | cloud (WhatsApp Business Cloud API)
        'driver' => env('WHATSAPP_DRIVER', 'callmebot'),
        // Overrides the number saved on the "Boula D" admin (digits only, with country code)
        'to' => env('WHATSAPP_TO'),
        // Times (app timezone) the digest is sent
        'digest_times' => env('WHATSAPP_DIGEST_TIMES', '08:00,13:00,18:00'),
        'callmebot' => [
            'apikey' => env('WHATSAPP_CALLMEBOT_APIKEY'),
        ],
        'cloud' => [
            'token' => env('WHATSAPP_CLOUD_TOKEN'),
            'phone_number_id' => env('WHATSAPP_CLOUD_PHONE_NUMBER_ID'),
            // Needed to message outside the 24h window; the template must have ONE body variable
            'template' => env('WHATSAPP_CLOUD_TEMPLATE'),
            'language' => env('WHATSAPP_CLOUD_TEMPLATE_LANGUAGE', 'en'),
        ],
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
