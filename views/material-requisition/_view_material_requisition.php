<?php


/* @var $this View */

/* @var $model MaterialRequisition|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\MaterialRequisition;
use app\models\User;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;
use yii\widgets\DetailView;

?>

<div class="card bg-transparent rounded">

    <div class="card-body">
        <div class="d-flex flex-row gap-1 mb-3">
           <?= Html::a(TextLinkEnum::PRINT->value, ['material-requisition/print-to-pdf', 'id' => $model->id], [
              'class' => 'btn btn-success',
              'target' => '_blank',
              'rel' => 'noopener noreferrer'
           ]) ?>

           <?= Html::a(TextLinkEnum::UPDATE->value, ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </div>
       <?php

       echo DetailView::widget([
          'model' => $model,
          'options' => [
             'class' => 'table table-bordered table-detail-view'
          ],
          'attributes' => [
             'nomor',
             [
                'attribute' => 'vendor_id',
                'value' => $model->vendor->nama,
             ],
             'tanggal:date',
             'remarks:ntext',
             [
                'attribute' => 'approved_by',
                'value' => $model->approvedBy->nama,
             ],
             [
                'attribute' => 'acknowledge_by',
                'value' => $model->acknowledgeBy->nama,
             ],
             [
                'attribute' => 'created_at',
                'format' => 'datetime',
             ],
             /*[
                 'attribute' => 'updated_at',
                 'format' => 'datetime',
             ],*/
             [
                'attribute' => 'created_by',
                'value' => function ($model) {
                   return User::findOne($model->created_by)->username ?? null;
                }
             ],
             /*[
                   'attribute' => 'updated_by',
                   'value' => function ($model) {
                       return User::findOne($model->updated_by)->username ?? null;
                   }
             ],*/
          ],
       ]);
       ?>

        <div class="table-responsive">
           <?php
           echo GridView::widget([
              'dataProvider' => new ActiveDataProvider([
                 'query' => $model->getMaterialRequisitionDetails(),
                 'sort' => false,
                 'pagination' => false
              ]),
              'layout' => '{items}',
              'columns' => [
                 [
                    'class' => SerialColumn::class
                 ],
                 [
                    'class' => DataColumn::class,
                    'attribute' => 'tipePembelianNama',
                    'value' => 'barang.tipePembelian.nama'
                 ],
                 [
                    'class' => DataColumn::class,
                    'attribute' => 'barang_id',
                    'value' => 'barang.nama'
                 ],
                 [
                    'class' => DataColumn::class,
                    'attribute' => 'description'
                 ],
                 [
                    'class' => DataColumn::class,
                    'attribute' => 'quantity',
                    'contentOptions' => [
                       'class' => 'text-end'
                    ]
                 ],
                 [
                    'class' => DataColumn::class,
                    'attribute' => 'satuan_id',
                    'value' => 'satuan.nama',
                    'contentOptions' => [
                       'class' => 'text-end'
                    ]
                 ],
              ]
           ]);
           ?>
        </div>

    </div>


</div>