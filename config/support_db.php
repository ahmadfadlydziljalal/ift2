<?php

use yii\helpers\ArrayHelper;

$default = [
    'class' => 'yii\db\Connection',
    'dsn' => getenv('DB_DSN_SUPPORT'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'charset' => 'utf8',
];

return YII_ENV_DEV ? $default : ArrayHelper::merge($default, [

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 60,
    'schemaCache' => 'cache',

]);