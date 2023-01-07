<?php

use app\components\grid\ActionColumn;
use app\models\Barang;
use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

return [
   [
      'class' => SerialColumn::class
   ],
   [
      'class' => ActionColumn::class,
      'template' => '{view-per-card-per-barang}',
      'buttons' => [
         'view-per-card-per-barang' => function ($url, $model) {
            return Html::a('<i class="bi bi-eye-fill"></i>',
               ['stock-per-gudang/view-per-card-per-barang',
                  'barangId' => $model->id,
                  'cardId' => Yii::$app->request->queryParams['id']
               ],
               [
                  'class' => 'text-primary'
               ]
            );
         }
      ],
   ],
   [
      'class' => DataColumn::class,
      'header' => 'Photo',
      'format' => 'raw',
      'contentOptions' => [
         'class' => 'text-center'
      ],
      'value' => function ($model) {
         /** @var Barang $model */
         return $model->photoThumbnailAsTagImgHtmlElement;
      }
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'part_number'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'ift_number'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'nama'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'merk_part_number'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'satuanNama'
   ],
   [
      'class' => DataColumn::class,
      'attribute' => 'qtyInit',
      'header' => 'INIT',
      'headerOptions' => [
         'title' => 'Init Start System'
      ],
      'contentOptions' => [
         'class' => 'text-end'
      ],
      'format' => ['decimal', 2]
   ],
   [
      'class' => DataColumn::class,
      'header' => 'TTB',
      'attribute' => 'qtyTandaTerimaBarang',
      'contentOptions' => [
         'class' => 'text-end'
      ],
      'headerOptions' => [
         'title' => 'Tanda Terima Barang'
      ],
      'format' => ['decimal', 2]
   ],
   [
      'class' => DataColumn::class,
      'header' => 'CPC',
      'attribute' => 'qtyClaimPettyCashNota',
      'contentOptions' => [
         'class' => 'text-end'
      ],
      'format' => ['decimal', 2],
      'headerOptions' => [
         'title' => 'Claim Petty Cash'
      ],
   ],
   [
      'class' => DataColumn::class,
      'header' => 'DR',
      'attribute' => 'qtyDeliveryReceipt',
      'contentOptions' => [
         'class' => 'text-end'
      ],
      'format' => ['decimal', 2],
      'headerOptions' => [
         'title' => 'Delivery Receipt'
      ],
   ],
   [
      'class' => DataColumn::class,
      'header' => 'MV-O',
      'headerOptions' => [
         'title' => 'Movement Out'
      ],
      'attribute' => 'qtyTransferKeluar',
      'contentOptions' => [
         'class' => 'text-end'
      ],
      'format' => ['decimal', 2]
   ],
   [
      'class' => DataColumn::class,
      'header' => 'MV-I',
      'headerOptions' => [
         'title' => 'Movement In'
      ],
      'attribute' => 'qtyTransferMasuk',
      'contentOptions' => [
         'class' => 'text-end'
      ],
      'format' => ['decimal', 2]
   ],

   [
      'class' => DataColumn::class,
      'header' => 'AVL',
      'headerOptions' => [
         'title' => 'Available'
      ],
      'attribute' => 'availableStock',
      'contentOptions' => [
         'class' => 'text-end'
      ],
      'format' => ['decimal', 2]
   ],


];