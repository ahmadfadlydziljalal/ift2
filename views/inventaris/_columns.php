<?php

use app\models\Card;
use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;

return [
   [
      'class' => SerialColumn::class,
   ],
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'id',
   // 'format'=>'text',
   // ],

   [
      'class' => DataColumn::class,
      'attribute' => 'kode_inventaris',
      'format' => 'text',
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'merk',
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'description',
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'material_requisition_detail_penawaran_id',
      'value' => 'materialRequisitionDetailPenawaran.purchaseOrder.nomor',
      'label' => 'Purchase Order',
      'format' => 'text',
      'hidden' => true,
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'location_id',
      'value' => 'location.nama',
      'filter' => Card::find()->map(Card::GET_ONLY_WAREHOUSE),
      'hidden' => true,
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'quantity',
      'format' => 'text',
      'contentOptions' => [
         'class' => 'text-end'
      ],
      'headerOptions' => [
         'class' => 'text-end'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'namaSatuan',
      'format' => 'text',
      'contentOptions' => [
         'class' => 'text-end'
      ],
      'headerOptions' => [
         'class' => 'text-end'
      ],
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'kondisi',
      'format' => 'text',
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'lastOrder',
      'format' => 'date'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'lastRepaired',
      'format' => 'datetime'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'lastRemarks',
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'lastLocation',
   ],
   [
      'class' => 'yii\grid\ActionColumn',
   ],
];   