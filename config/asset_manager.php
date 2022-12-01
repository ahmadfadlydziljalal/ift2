<?php

use yii\bootstrap5\BootstrapAsset;
use yii\web\JqueryAsset;

return [
   'dirMode' => 0755,
   'bundles' => [
      JqueryAsset::class => [
         'js' => [
            //YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js',
            YII_ENV_DEV ? 'https://code.jquery.com/jquery-3.5.1.js' : 'https://code.jquery.com/jquery-3.5.1.min.js'
         ]
      ],
      BootstrapAsset::class => [
         'css' => [],
      ],
   ],
   'appendTimestamp' => true,
   'forceCopy' => YII_ENV_DEV,
];