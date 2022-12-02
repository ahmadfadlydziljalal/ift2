<?php


use app\components\grid\ActionColumn;
use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;

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
      'template' => '{view}',
   ],
];