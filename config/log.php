<?php

use yii\log\DbTarget;

return [
    'traceLevel' => YII_DEBUG ? 3 : 0,
    'targets' => [
        [
            'class' => DbTarget::class,
            'db' => 'supportDb',
            'levels' => ['error', 'warning'],
        ],
    ],
];