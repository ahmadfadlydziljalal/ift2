<?php


use app\components\grid\ActionColumn;
use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

return [
   [
      'class' => SerialColumn::class
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'photo_thumbnail',
      'header' => 'Photo',
      'format' => 'raw',
      'value' => function ($model) {
         if ($model['photo_thumbnail']) {
            return Html::img($model['photo_thumbnail'], [
               'width' => 'auto',
               'height' => 'auto'
            ]);
         }
         return null;
      }
   ],
   'partNumber',
   [
      'class' => DataColumn::class,
      'attribute' => 'kodeBarang',
      'header' => 'Kode'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'namaBarang',
      'contentOptions' => [
         'class' => 'text-nowrap'
      ]
   ],
   'merk',
   [
      'class' => DataColumn::class,
      'attribute' => 'defaultSatuan',
      'header' => 'UOM'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'stockAwal',
      'contentOptions' => [
         'class' => 'text-end'
      ]
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'qtyMasuk',
      'contentOptions' => [
         'class' => 'text-end'
      ]
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'qtyKeluar',
      'contentOptions' => [
         'class' => 'text-end'
      ]
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'stockAkhir ',
      'contentOptions' => [
         'class' => 'text-end'
      ]
   ],
   [
      'class' => ActionColumn::class,
      'mergeHeader' => false,
      'template' => '{view}',
   ],
];