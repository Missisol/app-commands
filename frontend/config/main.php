<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'v1' => [
            'class' => 'frontend\modules\api\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => ['application/json' => 'yii\web\JsonParser'],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/index',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'api/v1' => 'v1',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/user'],
                    'pluralize' => false,
                    'prefix' => 'api/',
                    'extraPatterns' => [
                        'verify-email' => 'verify-email',
                        'auth' => 'auth',
                        'recovery' => 'recovery',
                        'reset-password' => 'reset-password',
                        'PATCH' => 'update',
                        'change-password' => 'change-password',
                        'change-email' => 'change-email',
                        'verify-new-email' => 'verify-new-email',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/board', 
                        'v1/task-tab', 
                        'v1/list', 
                        'v1/column',
                        'v1/task',
                        'v1/column-list',
                        'v1/list-issue',
                        'v1/issue'
                    ],
                    'pluralize' => false,
                    'prefix' => 'api/'
                ],
                '\w+|\W+' => '',
            ],
        ],
    ],
    'params' => $params,
    'defaultRoute' => 'site/index',
];
