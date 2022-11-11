<?php

/* @var $model MaterialRequisitionDetail */


use app\enums\TextLinkEnum;
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
            <div class="col-sm-12">

                <div class="d-flex flex-column flex-wrap">
                    <p>Tipe: <?= $model->barang->tipePembelian->nama ?></p>

                    <div class="d-flex flex-row align-items-baseline gap-2">
                        <?= Html::tag('h3', $model->barang->nama, ['class' => 'card-text']) ?>
                        <div>
                            <?= Html::tag('small', $model->quantity . ' ' . $model->satuan->nama, [
                                'class' => 'badge bg-info rounded-pill'
                            ]) ?>
                        </div>
                    </div>
                    <p><?= $model->description ?></p>
                </div>


            </div>
            <hr/>
            <div class="col-sm-12">
                <p class="card-text text-muted">Penawaran Harga</p>
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

                    <div class="mb-3">
                        <?php
                        echo Html::a(TextLinkEnum::UPDATE->value,
                            ['material-requisition/update-penawaran', 'materialRequisitionDetailId' => $model->id], [
                                'class' => 'btn btn-outline-info'
                            ]);
                        ?>

                        <?php
                        /* @see \app\controllers\MaterialRequisitionController::actionDeletePenawaran() */
                        echo Html::a(TextLinkEnum::DELETE->value,
                            ['material-requisition/delete-penawaran', 'materialRequisitionDetailId' => $model->id], [
                                'class' => 'btn btn-outline-danger',
                                'data' => [
                                    'confirm' => 'Anda yakin membatalkan penawaran untuk item ini ?',
                                    'method' => 'post'
                                ]
                            ]);
                        ?>
                    </div>

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
                                    'attribute' => 'mata_uang_id',
                                    'value' => 'mataUang.nama'
                                ],
                                [
                                    'class' => DataColumn::class,
                                    'attribute' => 'quantity_pesan',
                                    'format' => ['decimal', 2],
                                    'contentOptions' => [
                                        'class' => 'text-end'
                                    ]
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