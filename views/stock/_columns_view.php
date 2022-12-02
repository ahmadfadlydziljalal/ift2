<?php

use app\components\grid\ActionColumn;
use app\models\Stock;
use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Json;

return [
   [
      'class' => SerialColumn::class
   ],
   'partNumber',
   'kodeBarang',
   'namaBarang',
   'merk',
   'nomorTandaTerima',
   [
      'class' => DataColumn::class,
      'attribute' => 'tgl_tanda_terima',
      'header' => 'Tgl',
      'format' => 'date',
      'contentOptions' => [
         'class' => 'text-nowrap text-end'
      ]
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'qty_terima',
      'contentOptions' => [
         'class' => 'text-end'
      ]
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'historyLokasiBarangIn',
      'header' => 'History In',
      'format' => 'raw',
      'contentOptions' => [
         'class' => 'text-wrap'
      ],
      'value' => function ($model) {
         $items = (Json::decode($model['historyLokasiBarangIn']));

         $string = '';
         if ($items) {
            foreach ($items as $item) {
               $string .= Html::tag('span',

                     Html::tag('span', $item['quantity'], ['class' => 'badge bg-danger rounded']) . ' ' .
                     $item['lokasi'], ['class' => 'badge bg-info']
                  ) . ' ';
            }
         }
         return $string;
      }

   ],
   [
      'class' => ActionColumn::class,
      'mergeHeader' => false,
      'header' => 'Set Lokasi',
      'template' => '{set-lokasi-in} {set-lokasi-movement}',
      'buttons' => [

         'set-lokasi-in' => function ($url, $model, $key) {

            if (!$key || !is_null($model['historyLokasiBarangIn'])) {
               return '';
            }

            return Html::a('<i class="bi bi-box-arrow-down"></i> In', ['stock/set-lokasi', 'id' => $key, 'type' => Stock::TIPE_PERGERAKAN_IN], [
               'class' => 'btn btn-sm btn-primary'
            ]);
         },

         'set-lokasi-movement' => function ($url, $model, $key) {

            if (!$key || is_null($model['historyLokasiBarangIn'])) {
               return '';
            }
            return Html::a('<i class="bi bi-arrow-left-right"></i> Movement', ['stock/set-lokasi', 'id' => $key, 'type' => Stock::TIPE_PERGERAKAN_MOVEMENT], [
               'class' => 'btn btn-sm btn-success'
            ]);
         }
      ],
   ]
];