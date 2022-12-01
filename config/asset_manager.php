<?php

return [
    'dirMode' => 0755,
    'bundles' => [
        'yii\web\JqueryAsset' => [
            'js' => [
                YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
            ]
        ],
        'yii\bootstrap5\BootstrapAsset' => [
            'css' => [],
        ],
        'yii\bootstrap5\BootstrapPluginAsset' => [
            'js' => [
                YII_ENV_DEV ? 'js/bootstrap.bundle.js' : 'js/bootstrap.bundle.min.js',
            ]
        ]
    ],
    'appendTimestamp' => true,
    'forceCopy' => YII_ENV_DEV,
];
