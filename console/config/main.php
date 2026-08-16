<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => \yii\console\controllers\FixtureController::class,
            'namespace' => 'common\fixtures',
          ],
          'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                // ...
                'yii\queue\db\migrations',
            ],
        ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['info', 'warning', 'error'],
                    'categories' => [
                        'queue.notification',
                        'queue.notifications', // Added plural as a safety net
                        'common\jobs\*',
                    ],
                    'logFile' => '@console/runtime/logs/queue-notifications.log',
                    'logVars' => [], // Keeps $_SERVER / env vars OUT of your logs
                ],
            ],
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
                'port' => env('SMTP_PORT'),
                // 'dsn' => 'native://default',
            ],
            // DSN example:
            //  'transport' => [
            //      'dsn' => 'smtp://' . env('SMTP_USERNAME') . ':' . env('SMTP_PASSWORD') . '@' . env('SMTP_HOST') . ':25',
            //   ],

        ],
    ],
    'params' => $params,
];
