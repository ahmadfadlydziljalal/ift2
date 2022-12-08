<?php

use app\models\Card;
use app\models\PurchaseOrder;
use kartik\grid\DataColumn;
use kartik\grid\GridViewInterface;
use yii\bootstrap5\Html;
use yii\helpers\Url;

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
      'class' => 'kartik\grid\ExpandRowColumn',
      'width' => '50px',
      'detailUrl' => Url::toRoute(['purchase-order/expand-item']),
      'expandOneOnly' => true,
      'header' => '',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'nomor',
      'format' => 'text',
      'value' => function ($model) {
         /** @var PurchaseOrder $model */
         return $model->getNomorDisplay();
      }
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'vendorPurchaseOrder',
      'header' => 'Vendor',
      'format' => 'text',
      'value' => 'vendor.nama',
      'filterType' => GridViewInterface::FILTER_SELECT2,
      'filter' => Card::find()->map(Card::GET_ONLY_VENDOR),
      'filterWidgetOptions' => [
         'options' => [
            'prompt' => '= Pilih salah satu ='
         ]
      ]
   ],

   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'tanggal',
      'format' => 'date',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'nomorMaterialRequest',
      'header' => 'M.R',
      'format' => 'text',
      //'value' => 'materialRequisition.nomor'
      'value' => function ($model) {
         /** @var PurchaseOrder $model */
         return $model->materialRequisition->getNomorDisplay();
      }
   ],
   [
      //'attribute' => 'nomorTandaTerimaBarang',
      'format' => 'raw',
      'header' => 'Tanda Terima',
      'value' => function ($model) {
         /** @var PurchaseOrder $model */
         return $model->nomorTandaTerimaColumnsAsHtml;
      }
   ],
   [
      'header' => 'Status Terima',
      'format' => 'raw',
      'value' => function ($model) {
         /** @var PurchaseOrder $model */
         return $model->getStatusTandaTerimaBarangsAsHtml();

      }
   ],
   /*[
       'class' => '\yii\grid\DataColumn',
       'attribute' => 'reference_number',
       'format' => 'text',
   ],
   [
       'class' => '\yii\grid\DataColumn',
       'attribute' => 'remarks',
       'format' => 'ntext',
   ],*/
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'approved_by',
   // 'format'=>'text',
   // ],
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'acknowledge_by',
   // 'format'=>'text',
   // ],
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'created_at',
   // 'format'=>'text',
   // ],
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'updated_at',
   // 'format'=>'text',
   // ],

   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'updated_by',
   // 'format'=>'text',
   // ],
   [
      'class' => 'yii\grid\ActionColumn',
      'template' => '{print} {view} {update} {delete}',
      'buttons' => [
         'print' => function ($url, $model) {
            return Html::a('<i class="bi bi-printer-fill"></i>', ['purchase-order/print-to-pdf', 'id' => $model->id], [
               'class' => 'print text-success',
               'target' => '_blank',
               'rel' => 'noopener noreferrer'
            ]);
         },
      ],
   ],
];   