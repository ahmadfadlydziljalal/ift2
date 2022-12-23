<?php

use app\enums\TextLinkEnum;
use app\models\User;
use mdm\admin\components\Helper;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\InventarisLaporanPerbaikanMaster */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Inventaris Laporan Perbaikan Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventaris-laporan-perbaikan-master-view">

    <div class="d-flex justify-content-between flex-wrap mb-3" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

           <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
           <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
           <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
           <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
           <?= Html::a(TextLinkEnum::PRINT->value, ['inventaris-laporan-perbaikan-master/print-to-pdf', 'id' => $model->id], [
              'class' => 'btn btn-success',
              'target' => '_blank',
              'rel' => 'noopener noreferrer'
           ]) ?>
           <?php
           if (Helper::checkRoute('delete')) :
              echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                 'class' => 'btn btn-outline-danger',
                 'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                 ],
              ]);
           endif;
           ?>
        </div>
    </div>

   <?php try {
      echo DetailView::widget([
         'model' => $model,
         'options' => [
            'class' => 'table table-bordered table-detail-view'
         ],
         'attributes' => [
            'nomor',
            'tanggal:date',
            [
               'attribute' => 'card_id',
               'value' => $model->card->nama,
            ],
            [
               'attribute' => 'status_id',
               'value' => ucwords($model->status->key),
            ],
            'comment:nText',
            [
               'attribute' => 'approved_by_id',
               'value' => $model->approvedBy->nama,
            ],
            [
               'attribute' => 'known_by_id',
               'value' => $model->knownBy->nama,
            ],
            [
               'attribute' => 'created_at',
               'format' => 'datetime',
            ],
            [
               'attribute' => 'updated_at',
               'format' => 'datetime',
            ],
            [
               'attribute' => 'created_by',
               'value' => function ($model) {
                  return User::findOne($model->created_by)->username ?? null;
               }
            ],
            [
               'attribute' => 'updated_by',
               'value' => function ($model) {
                  return User::findOne($model->updated_by)->username ?? null;
               }
            ],
         ],
      ]);

      echo Html::tag('h2', 'Detail Laporan Perbaikan Inventaris');
      echo !empty($model->inventarisLaporanPerbaikanDetails) ?
         GridView::widget([
            'dataProvider' => new ArrayDataProvider([
               'allModels' => $model->inventarisLaporanPerbaikanDetails
            ]),
            'columns' => [
               // [
               // 'class'=>'\yii\grid\DataColumn',
               // 'attribute'=>'id',
               // ],
               // [
               // 'class'=>'\yii\grid\DataColumn',
               // 'attribute'=>'inventaris_laporan_perbaikan_master_id',
               // ],
               [
                  'class' => '\yii\grid\DataColumn',
                  'attribute' => 'inventaris_id',
                  'value' => 'inventaris.kode_inventaris'
               ],
               [
                  'class' => '\yii\grid\DataColumn',
                  'attribute' => 'kondisi_id',
                  'value' => 'kondisi.key'
               ],
               [
                  'class' => '\yii\grid\DataColumn',
                  'attribute' => 'last_location_id',
                  'value' => 'lastLocation.nama'
               ],
               [
                  'class' => '\yii\grid\DataColumn',
                  'attribute' => 'last_repaired',
                  'format' => 'datetime'
               ],
               [
                  'class' => '\yii\grid\DataColumn',
                  'attribute' => 'remarks',
                  'format' => 'nText'
               ],
               [
                  'class' => '\yii\grid\DataColumn',
                  'attribute' => 'estimated_price',
                  'format' => ['decimal', 2]
               ],
            ]
         ]) :
         Html::tag("p", 'Inventaris Laporan Perbaikan Detail tidak tersedia', [
            'class' => 'text-warning font-weight-bold p-3'
         ]);
   } catch (Exception $e) {
      echo $e->getMessage();
   } catch (Throwable $e) {
      echo $e->getMessage();
   }
   ?>

</div>