<?php

use app\enums\TipePembelianEnum;
use app\models\Originalitas;
use app\models\TipePembelian;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

return [
   [
      'class' => SerialColumn::class,
      'contentOptions' => [
         'class' => 'align-middle text-end'
      ],
   ],
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'id',
   // 'format'=>'text',
   // ],
   [
      'class' => 'kartik\grid\ExpandRowColumn',
      'width' => '50px',
      'detail' => function ($model, $key, $index, $column) {
         return $this->context->renderPartial('_item', ['model' => $model]);
      },
      'headerOptions' => ['class' => 'kartik-sheet-style'],
      'expandOneOnly' => true
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'tipe_pembelian_id',
      'filter' => TipePembelian::find()->map([TipePembelianEnum::STOCK->value, TipePembelianEnum::PERLENGKAPAN->value]),
      'value' => function ($model) {
         return $model->tipePembelianNama;
      },
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'nama',
      'format' => 'text',
      'contentOptions' => [
         'class' => 'text-nowrap'
      ]
   ],

   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'part_number'
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'merk_part_number',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'ift_number',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'originalitas_id',
      'filter' => Originalitas::find()->map(),
      'value' => function ($model) {
         return $model->originalitasNama;
      },
      'contentOptions' => [
         'class' => 'text-nowrap'
      ]
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'photo',
      'format' => 'raw',
      'contentOptions' => [
         'class' => 'text-center'
      ],
      'value' => function ($model) {
         return empty($model->photo_thumbnail)
            ? ''
            : Html::img($model->photo_thumbnail, [
               'alt' => 'No image available',
               'loading' => 'lazy',
               'height' => '32rem',
               'width' => 'auto',
            ]);
      }
   ],
   [
      'class' => 'yii\grid\ActionColumn',
      'contentOptions' => [
         'class' => 'text-nowrap'
      ],
   ],
];   