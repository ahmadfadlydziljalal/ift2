<?php

use app\models\HistoryLokasiBarang;

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
      'attribute' => 'nomor',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'card_id',
      'format' => 'text',
      'value' => 'card.kode'
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'dokumenPendukung',
      'value' => function ($model) {
         /** @var HistoryLokasiBarang $model */
         return $model->nomorDokumenPendukung;
      }
   ],
//   [
//      'class' => '\yii\grid\DataColumn',
//      'attribute' => 'tanda_terima_barang_detail_id',
//      'format' => 'text',
//      'value' => 'tandaTerimaBarangDetail.tandaTerima.nomor'
//   ],
//   [
//      'class' => '\yii\grid\DataColumn',
//      'attribute' => 'claim_petty_cash_nota_detail_id',
//      'format' => 'raw',
//      'value' => 'claimPettyCashNotaDetail.claimPettyCashNota.claimPettyCash.nomor',
//   ],
//   [
//      'class' => '\yii\grid\DataColumn',
//      'attribute' => 'quotation_delivery_receipt_detail_id',
//      'format' => 'text',
//      'value' => 'quotationDeliveryReceiptDetail.quotationDeliveryReceipt.nomor'
//   ],
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'tipe_pergerakan_id',
   // 'format'=>'text',
   // ],
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'step',
   // 'format'=>'text',
   // ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'quantity',
      'format' => 'text',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'block',
      'format' => 'text',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'rak',
      'format' => 'text',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'tier',
      'format' => 'text',
   ],
   [
      'class' => '\yii\grid\DataColumn',
      'attribute' => 'row',
      'format' => 'text',
   ],
   // [
   // 'class'=>'\yii\grid\DataColumn',
   // 'attribute'=>'catatan',
   // 'format'=>'ntext',
   // ],
//   [
//      'class' => '\yii\grid\DataColumn',
//      'attribute' => 'depend_id',
//      'format' => 'text',
//   ],
   [
      'class' => 'yii\grid\ActionColumn',
   ],
];   