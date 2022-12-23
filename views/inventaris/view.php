<?php

use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use mdm\admin\components\Helper;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Inventaris */
/* @see app\controllers\InventarisController::actionView() */

$this->title = $model->kode_inventaris;
$this->params['breadcrumbs'][] = ['label' => 'Inventaris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="inventaris-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

           <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
           <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
           <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
           <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
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

    <div class="flex flex-column gap-3">
       <?php try {
          echo DetailView::widget([
             'model' => $model,
             'options' => [
                'class' => 'table table-bordered table-detail-view'
             ],
             'attributes' => [
                'kode_inventaris',
                [
                   'attribute' => 'material_requisition_detail_penawaran_id',
                   'value' => $model->materialRequisitionDetailPenawaran->purchaseOrder->nomor
                ],
                [
                   'attribute' => 'location_id',
                   'value' => $model->location->nama
                ],
                'quantity',
             ],
          ]);
       } catch (Throwable $e) {
          echo $e->getMessage();
       }
       ?>

       <?php

       echo GridView::widget([
          'dataProvider' => new ActiveDataProvider([
             'query' => $model->getInventarisLaporanPerbaikanDetails(),
             'sort' => false
          ]),
          'pjax' => true,
          'columns' => [
             [
                'class' => SerialColumn::class
             ],
             [
                'class' => DataColumn::class,
                'attribute' => 'inventaris_laporan_perbaikan_master_id',
                'value' => 'inventarisLaporanPerbaikanMaster.nomor'
             ],
             [
                'class' => DataColumn::class,
                'attribute' => 'kondisi_id',
                'value' => 'kondisi.key'
             ],
             [
                'class' => DataColumn::class,
                'attribute' => 'last_location_id',
                'value' => 'lastLocation.nama'
             ],
             [
                'class' => DataColumn::class,
                'attribute' => 'last_repaired',
                'format' => 'datetime'
             ],
             [
                'class' => DataColumn::class,
                'attribute' => 'remarks',
                'format' => 'nText'
             ],
             [
                'class' => DataColumn::class,
                'attribute' => 'estimated_price',
                'format' => ['decimal', 2],
                'contentOptions' => [
                   'class' => 'text-end'
                ]
             ],
          ],
       ]);

       ?>

    </div>


</div>