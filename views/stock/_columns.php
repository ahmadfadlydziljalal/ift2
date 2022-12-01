<?php


use app\components\grid\ActionColumn;
use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

return [
   [
      'class' => SerialColumn::class
   ],
   'partNumber',
   'kodeBarang',
   'namaBarang',
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
      'template' => '{view-stock-in} {view-stock-out}',
      'buttons' => [
         'view-stock-in' => function ($url, $model, $key) {
            return Html::a('<i class="bi bi-arrow-left-circle"></i> In ', ['stock/view-stock-in', 'id' => $key], [
               'class' => 'text-primary text-decoration-none'
            ]);
         },
         'view-stock-out' => function ($url, $model, $key) {
            return Html::a('<i class="bi bi-arrow-right-circle"></i> Out', ['stock/view-stock-out', 'id' => $key], [
               'class' => 'text-danger text-decoration-none'
            ]);
         }
      ]
   ],
];