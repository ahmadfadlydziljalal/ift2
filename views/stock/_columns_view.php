<?php

use app\models\Card;
use app\models\HistoryLokasiBarang;
use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;
use yii\helpers\Inflector;

return [
   [
      'class' => SerialColumn::class
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'type',
      'filter' => HistoryLokasiBarang::optsHistoryType(),
      'value' => function ($model) {
         return ucwords(Inflector::humanize($model['type']));
      }
   ],
   # 'partNumber',
   # 'kodeBarang',
   # 'namaBarang',
   # 'merk',
   [
      'class' => DataColumn::class,
      'attribute' => 'nomorHistory',
   ],
   'dependNomorDokumen',
   [
      'class' => DataColumn::class,
      'filter' => Card::find()->map(Card::GET_ONLY_WAREHOUSE),
      'attribute' => 'gudangId',
      'value' => function ($model) {
         return $model['gudang'];
      }
   ],
   'block',
   'rak',
   'tier',
   'row'
   /*[
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

   ],*/
   /*   [
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
               return Html::a('<i class="bi bi-arrow-left-right"></i> Movement', ['stock/set-movement-lokasi', 'id' => $key], [
                  'class' => 'btn btn-sm btn-success'
               ]);
            }
         ],
      ]*/
];