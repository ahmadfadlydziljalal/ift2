<?php

use app\models\Card;

return [
   [
      'class' => 'yii\grid\SerialColumn',
   ],
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'id',
   // 'format'=>'text',
   // ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'card_id',
      'value' => 'card.nama',
      'filter' => Card::find()->map(Card::GET_ONLY_CUSTOMER),
      'format' => 'text',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'nama',
      'format' => 'text',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'lokasi',
      'format' => 'nText',
      'contentOptions' => [
         'class' => 'text-wrap',
      ],
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'tanggal_produk',
      'format' => 'date',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'serial_number',
      'format' => 'text',
   ],
   [
      'class' => 'yii\grid\ActionColumn',
   ],
];   