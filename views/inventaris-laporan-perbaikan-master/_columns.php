<?php

use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;

return [
   [
      'class' => SerialColumn::class,
   ],
   // [
   // 'class'=>DataColumn::class,
   // 'attribute'=>'id',
   // 'format'=>'text',
   // ],
   [
      'class' => DataColumn::class,
      'attribute' => 'nomor',
      'format' => 'text',
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'tanggal',
      'format' => 'date',
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'card_id',
      'format' => 'text',
      'value' => 'card.nama'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'status_id',
      'format' => 'text',
      'value' => 'status.key'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'comment',
      'format' => 'nText',
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'approved_by_id',
      'format' => 'nText',
      'value' => 'approvedBy.nama'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'known_by_id',
      'format' => 'nText',
      'value' => 'knownBy.nama'

   ],
   [
      'class' => 'yii\grid\ActionColumn',
   ],
];   