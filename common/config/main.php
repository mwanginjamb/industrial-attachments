<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
<<<<<<< HEAD
        'assetManager' => [
            'appendTimestamp' => true,
        ],

=======
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=127.0.0.1;dbname=industrial_attachments;port=3309',
            'username' => env('DB_USER'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            // send all mails to a file by default.
            'useFileTransport' => false,
            // SMTP server example:
                'transport' => [
                    'scheme' => 'smtp',
                    'host' => env('SMTP_HOST'),
                    'username' => env('SMTP_USERNAME'),
                    'password' => env('SMTP_PASSWORD'),
                    'port' => 465,
                   // 'dsn' => 'native://default',
                ],
            // DSN example:
                'transport' => [
                    'dsn' => 'smtp://'.env('SMTP_USERNAME').':'.env('SMTP_PASSWORD').'@'.env('SMTP_HOST').':25',
               ],
            
        ],
        
>>>>>>> 534df7ed4e4875c0ee17e8884e31c8cec2ed5499
    ],
];
