<?php

use yii\symfonymailer\Mailer;

$params = require __DIR__ . '/params.php';

/**
 * Application configuration shared by all test types
 */
return [
    'aliases' => require __DIR__ . '/aliases.php',
    'basePath' => dirname(__DIR__),
    'components' => [
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'authManager' => require __DIR__ . '/auth_manager.php',
        'db' => require __DIR__ . '/test_db.php',
        'mongodb' => require __DIR__ . '/test_mongodb.php',
        'i18n' => require __DIR__ . '/i18n.php',
        'mailer' => [
            'class' => Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
            'messageClass' => 'yii\symfonymailer\Message'
        ],
        /*'urlManager' => [
            'showScriptName' => true,
        ],*/
        'urlManager' => require __DIR__ . '/url_manager.php',
        'user' => require __DIR__ . '/user.php',
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
        'settings' => require __DIR__ . '/settings.php',
    ],
    'id' => 'basic-tests',
    'language' => 'en-US',
    'modules' => require __DIR__ . '/modules.php',
    'name' => strtoupper(getenv('APP_NAME')),
    'params' => $params,
];