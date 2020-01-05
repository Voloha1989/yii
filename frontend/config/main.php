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
    'modules' => [
        'dynagrid' => [
            'class' => '\kartik\dynagrid\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'api' => [
            'class' => 'frontend\modules\api\ApiModule',
        ],
    ],

    'controllerNamespace' => 'frontend\controllers',

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            /*'baseUrl' => str_replace('/frontend/web', '', (new Request())->getBaseUrl()),*/
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],

        /*'response' => [
            'format' => Response::FORMAT_JSON
        ],*/

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
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
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'pluralize' => false,
                    'controller' => ['api/books'],
                ],
            ],
        ],
    ],

    'params' => $params,
];
