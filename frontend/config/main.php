<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

use kartik\mpdf\Pdf;

return [
    'name'=>'Comedor',
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone'=>'America/Caracas',//para definir bien la hora local
    'controllerNamespace' => 'frontend\controllers',
    'modules'=>[
        'admin' => [
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'frontend\models\Usuario',
                    'idField' => 'iduser',
                    'usernameField' => 'username',
                    //'fullnameField' => 'profile.full_name',
                    'extraColumns' => [
                        [
                            'attribute' => 'email',
                            'label' => 'email',
                            'value' => function($model, $key, $index, $column) {
                                return $model->email;
                            },
                        ],
                        [
                            'attribute' => 'password',
                            'label' => 'Contraseña',
                            'value' => function($model, $key, $index, $column) {
                                return $model->password;
                            },
                        ],
                    ],
                    'searchClass' => 'frontend\models\UsuarioSearch'
                ],
            ],
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu', // por defaults es null, cuando no deseas usar el menú Otros valores opcionales son 'right-menu' and 'top-menu'
            'menus' => [
                'assignment' => [
                    'label' => 'Asignaciones'// change label
                ],
                'role' => 'Role de Usuario', // disable menu
                'permission' => 'Permisos', // disable menu
                'route' => 'Rutas', // disable menu
                'rule' => 'Reglas', // disable menu
            ],
            'mainLayout' => '@app/views/layouts/main.php',// utiliza el menu del framework
        ]
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'frontend\models\Usuario',
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
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'pdf' => [
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/index',
            'site/login',
        ]
    ],
    'params' => $params,
];
