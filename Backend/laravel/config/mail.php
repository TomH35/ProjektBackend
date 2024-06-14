<?php

return [

    'default' => env('MAIL_MAILER', 'smtp'),

    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],

        'postmark' => [
            'transport' => 'postmark',
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'mailgun' => [
            'transport' => 'mailgun',
        ],

        'mandrill' => [
            'transport' => 'mandrill',
        ],

        'sparkpost' => [
            'transport' => 'sparkpost',
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],
    ],

    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'miroslav.majersky@student.ukf.sk'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],

    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];

