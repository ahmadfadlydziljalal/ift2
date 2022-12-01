<?php

use yii\bootstrap5\BootstrapAsset;
use yii\web\JqueryAsset;

return [
   'dirMode' => 0755,
   'bundles' => [
      JqueryAsset::class => [
         'js' => [
            YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
         ]
      ],
      BootstrapAsset::class => [
         'css' => [],
         'depends' => [
            JqueryAsset::class,
         ]
      ],
   ],
   'appendTimestamp' => true,
   'forceCopy' => YII_ENV_DEV,
];