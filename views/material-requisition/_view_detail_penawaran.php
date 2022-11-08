<?php

/* @var $model MaterialRequisitionDetail */


use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>

<div class="card">


    <div class="card-body">


        <div class="row">
            <div class="col-sm-12 col-md-4">
                <h4 class="card-text"><?= $model->barang->nama ?></h4>
                <p><?= $model->barang->tipePembelian->nama ?></p>

                <p><?= $model->description ?></p>
                <p><?= $model->quantity ?> <?= $model->satuan->nama ?></p>
            </div>
            <div class="col-sm-12 col-md-8">
                <h4 class="card-text">Penawaran Harga</h4>
                <?php if (empty($model->materialRequisitionDetailPenawarans)) : ?>
                    <p>
                        <?php
                        echo Html::a('<i class="bi bi-plus-circle"></i> Buat',
                            ['material-requisition/create-penawaran', 'materialRequisitionDetailId' => $model->id], [
                                'class' => 'btn btn-success'
                            ]);
                        ?>
                    </p>

                <?php else: ?>

                    <p>
                        <?php
                        echo Html::a('<i class="bi bi-pencil"></i> Update',
                            ['material-requisition/update-penawaran', 'materialRequisitionDetailId' => $model->id], [
                                'class' => 'btn btn-outline-info'
                            ]);
                        ?>
                        <?php
                        /* @see \app\controllers\MaterialRequisitionController::actionDeletePenawaran() */
                        echo Html::a('<i class="bi bi-trash-fill"></i> Hapus',
                            ['material-requisition/delete-penawaran', 'materialRequisitionDetailId' => $model->id], [
                                'class' => 'btn btn-outline-danger',
                                'data' => [
                                    'confirm' => 'Anda yakin membatalkan penawaran untuk item ini ?',
                                    'method' => 'post'
                                ]
                            ]);
                        ?>
                    </p>

                    <div class="table-responsive">
                        <?php
                        echo GridView::widget([
                            'dataProvider' => new ActiveDataProvider([
                                'query' => $model->getMaterialRequisitionDetailPenawarans()
                            ]),
                            'layout' => '{items}',
                            'columns' => [
                                [
                                    'class' => SerialColumn::class
                                ],
                                [
                                    'class' => DataColumn::class,
                                    'attribute' => 'vendor_id',
                                    'value' => 'vendor.nama'
                                ],
                                [
                                    'class' => DataColumn::class,
                                    'attribute' => 'harga_penawaran',
                                    'format' => ['decimal', 2],
                                    'contentOptions' => [
                                        'class' => 'text-end'
                                    ]
                                ],
                                [
                                    'attribute' => 'statusLabel',
                                    'format' => 'raw'
                                ],
                                [
                                    'class' => DataColumn::class,
                                    'attribute' => 'purchase_order_id',
                                    'value' => function ($model) {
                                        /** @var MaterialRequisitionDetailPenawaran $model */
                                        return empty($model->purchaseOrder) ? '' : $model->purchaseOrder->nomor;
                                    }
                                ],
                            ]
                        ]);
                        ?>
                    </div>


                <?php endif ?>

            </div>
        </div>
    </div>
</div>