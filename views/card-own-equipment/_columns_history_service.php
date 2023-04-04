<?php

use app\components\grid\ActionColumn;
use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;
use yii\bootstrap5\Html;

return [
   [
      'class' => SerialColumn::class
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'tanggal_service_saat_ini',
      'headerOptions' => [
         'class' => 'text-wrap'
      ],
      'format' => 'date'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'hour_meter_saat_ini',
      'format' => ['decimal', 0],
      'headerOptions' => [
         'class' => 'text-wrap'
      ],
      'contentOptions' => [
         'class' => 'text-end'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'kondisi_terakhir',
      'headerOptions' => [
         'class' => 'text-wrap align-middle'
      ],
      'format' => 'nText'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'service_terakhir',
      'format' => ['decimal', 0],
      'headerOptions' => [
         'class' => 'text-wrap'
      ],
      'contentOptions' => [
         'class' => 'text-end'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'service_selanjutnya',
      'format' => ['decimal', 0],
      'headerOptions' => [
         'class' => 'text-wrap'
      ],
      'contentOptions' => [
         'class' => 'text-end'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'hour_meter_service_selanjutnya',
      'format' => ['decimal', 0],
      'headerOptions' => [
         'class' => 'text-wrap'
      ],
      'contentOptions' => [
         'class' => 'text-end'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'tanggal_service_selanjutnya',
      'headerOptions' => [
         'class' => 'text-wrap'
      ],
      'format' => 'date'
   ],
   [
      'class' => ActionColumn::class,
      'dropdown' => false,
      'template' => '{update-history-service} {delete-history-service}',
      'buttons' => [

         'divider' => fn($url, $model, $key) => '<li><hr class="dropdown-divider"></li>',

         /** @see \app\controllers\CardOwnEquipmentController::actionUpdateHistoryService() */
         'update-history-service' => fn($url, $model, $key) => Html::a('<i class="bi bi-pencil"></i>', $url, [
            'data-pjax' => '0'
         ]),

         'delete-history-service' => fn($url, $model, $key) => Html::a('<i class="bi bi-trash"></i>', $url, [
            'data-pjax' => '0',
            'data-method' => 'post',
            'data-confirm' => 'Apakah Anda akan menghapus record history ini ?',
            'class' => 'text-danger'
         ]),
      ]
   ],
];