<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'name' => 'Attachment Manager',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log','queue'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCsrfValidation' => YII_ENV === 'dev' ? false : true, // disable csrf validation on test only
            'enableCookieValidation' => true,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'authTimeout' => 1800, // 30 min
            'absoluteAuthTimeout' => 1800, // 30 min
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'class' => 'yii\web\Session',
            'timeout' => 3600, // 60 min
            'useCookies' => true,
            'cookieParams' => [
                'httponly' => true,
                'lifetime' => 3600, // one hour
                'samesite' => YII_ENV === 'dev' ? 'Lax' : 'None', // Allow cross-origin requests only in dev
                'secure' => YII_ENV === 'dev' ? false : true,     // Ensure secure (HTTPS) transmission only on dev
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
                // Queue notification logs
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['info','warning','error'],
                    'categories' => [
                        'queue.notification'
                    ],
                    'logFile' => '@runtime/logs/queue-notifications.log',
                    'logVars' => [],
                ],
            ],
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config 
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => yii\rest\UrlRule::class,
                    'controller' => [
                        'apiv1/application',
                        'apiv1/long-list-application',
                    ],
                ]
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true
        ]

    ],
    'modules' => [
        'apiv1' => [
            'class' => 'frontend\modules\apiv1\Module',
        ]
    ],
    'params' => $params,
];
