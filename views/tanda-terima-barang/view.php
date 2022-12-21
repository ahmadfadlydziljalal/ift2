<?php

use app\enums\TextLinkEnum;
use app\models\TandaTerimaBarang;
use app\models\TandaTerimaBarangDetail;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use mdm\admin\components\Helper;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TandaTerimaBarang */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Tanda Terima Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tanda-terima-barang-view">

   <?php if (!Yii::$app->request->isAjax) : ?>
       <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
           <h1><?= Html::encode($this->title) ?></h1>
           <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
              <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
              <?= Html::a(TextLinkEnum::KEMBALI->value, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
              <?= Html::a(TextLinkEnum::PRINT->value, ['print', 'id' => $model->id], [
                 'class' => 'btn btn-outline-success',
                 'target' => '_blank',
                 'rel' => 'noopener noreferrer'
              ]) ?>
              <?= Html::a(TextLinkEnum::UPDATE->value, ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
              <?php
              if (Helper::checkRoute('delete')) :
                 echo Html::a(TextLinkEnum::HAPUS->value, ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data' => [
                       'confirm' => 'Are you sure you want to delete this item?',
                       'method' => 'post',
                    ],
                 ]);
              endif;
              ?>
              <?= Html::a(TextLinkEnum::BUAT_LAGI->value, ['tanda-terima-barang/before-create'], ['class' => 'btn btn-success']) ?>
           </div>
       </div>

   <?php endif; ?>

    <div class="row">
        <div class="col-12 col-md-8">
           <?php try {
              echo DetailView::widget([
                 'model' => $model,
                 'options' => [
                    'class' => 'table table-bordered table-detail-view'
                 ],
                 'attributes' => [
                    'nomor',
                    'tanggal:date',
                    'catatan:nText',
                    'received_by',
                    'messenger',
                    [
                       'attribute' => 'acknowledge_by_id',
                       'value' => function ($model) {
                          /** @var TandaTerimaBarang $model */
                          return $model->acknowledgeBy->nama;
                       }
                    ],
                    [
                       'label' => 'Purchase Order',
                       'format' => 'raw',
                       'value' =>
                          Html::tag('span', $model->purchaseOrder->nomor, ['class' => 'fw-bold']) . ' ' .
                          $model->purchaseOrder->statusTandaTerimaBarangsAsHtml
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
                          return app\models\User::findOne($model->created_by)->username;
                       }
                    ],
                    [
                       'attribute' => 'updated_by',
                       'value' => function ($model) {
                          return app\models\User::findOne($model->updated_by)->username;
                       }
                    ],
//                        [
//                            'label' => 'Purchase Order',
//                            'value' => $model->purchaseOrder->nomor
//                        ],
                    /*[
                        'attribute' => 'status_pesanan_yang_sudah_diterima',
                        'format' => 'raw',
                        'value' => Html::tag('pre', VarDumper::dumpAsString($model->getStatusPesananYangSudahDiterima()))
                    ],*/
                 ],
              ]);
           } catch (Exception $e) {
              echo $e->getMessage();
           }
           ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
           <?php
           echo GridView::widget([
              'dataProvider' => new ActiveDataProvider([
                 'query' => $model->getTandaTerimaBarangDetails(),
                 'sort' => false,
                 'pagination' => false
              ]),
              'columns' => [
                 [
                    'class' => SerialColumn::class
                 ],
                 [
                    'class' => DataColumn::class,
                    'vAlign' => 'middle',
                    'format' => 'raw',
                    'header' => 'Part Number',
                    'value' => function ($model) {
                       /** @var TandaTerimaBarangDetail $model */
                       return
                          $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->part_number . '<br/>' .
                          $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->merk_part_number;
                    },
                 ],
                 [
                    'class' => DataColumn::class,
                    'format' => 'raw',
                    'vAlign' => 'middle',
                    'header' => 'Nama Barang',
                    'value' => function ($model) {
                       /** @var TandaTerimaBarangDetail $model */
                       return
                          $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->nama . '<br/>' .
                          $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->ift_number;
                    },
                 ],
                 [
                    'class' => DataColumn::class,
                    'format' => 'raw',
                    'vAlign' => 'middle',
                    'attribute' => 'material_requisition_detail_penawaran_id',
                    'header' => 'Total Qty Pesan',
                    'value' => function ($model) {
                       /** @var TandaTerimaBarangDetail $model */
                       return $model->materialRequisitionDetailPenawaran->quantity_pesan;
                    },
                    'contentOptions' => [
                       'class' => 'text-end'
                    ],
                    'headerOptions' => [
                       'class' => 'text-end'
                    ],
                 ],
                 [
                    'class' => DataColumn::class,
                    'vAlign' => 'middle',
                    'attribute' => 'quantity_terima',
                    'header' => 'Total Qty Terima',
                    'contentOptions' => [
                       'class' => 'text-end'
                    ],
                    'headerOptions' => [
                       'class' => 'text-end'
                    ],
                 ],
                 [
                    'class' => DataColumn::class,
                    'vAlign' => 'middle',
                    'attribute' => 'material_requisition_detail_penawaran_id',
                    'format' => 'raw',
                    'header' => 'Status Penerimaan',
                    'value' => function ($model) {
                       /** @var TandaTerimaBarangDetail $model */
                       return $model->materialRequisitionDetailPenawaran->getStatusPenerimaanInHtmlLabel();
                    },
                    'contentOptions' => [
                       'class' => 'text-end'
                    ],
                    'headerOptions' => [
                       'class' => 'text-end'
                    ],
                 ],
                 [
                    'class' => DataColumn::class,
                    'vAlign' => 'middle',
                    'header' => 'Detail',
                    'format' => 'raw',
                    'contentOptions' => [
                       'class' => 'p-2'
                    ],
                    'value' => function ($model) {
                       /** @var TandaTerimaBarangDetail $model */
                       return GridView::widget([
                          'dataProvider' => new ActiveDataProvider([
                             'query' => $model->materialRequisitionDetailPenawaran
                                ->materialRequisitionDetail
                                ->getTandaTerimaBarangDetails(),
                             'sort' => false,
                             'pagination' => false
                          ]),
                          'tableOptions' => [
                             'class' => 'table table-striped m-0'
                          ],
                          'layout' => '{items}',
                          'columns' => [
                             [
                                'class' => SerialColumn::class
                             ],
                             [
                                'attribute' => 'tanda_terima_barang_id',
                                'format' => 'raw',
                                'value' => function ($model) {
                                   /** @var TandaTerimaBarangDetail $model */
                                   return Html::a($model->tandaTerimaBarang->nomor, ['tanda-terima-barang/view', 'id' => $model->tandaTerimaBarang->id], [
                                      'class' => 'text-primary'
                                   ]);
                                },
                             ],
                             //'quantity_terima'
                             [
                                'attribute' => 'quantity_terima',
                                'format' => ['decimal', 2],
                                'contentOptions' => [
                                   'class' => 'text-end'
                                ]
                             ],
                          ]
                       ]);
                    },
                 ],
              ]
           ])
           ?>
        </div>
    </div>
</div>