<?php

/* @var $model MaterialRequisitionDetail */

/* @var $this yii\web\View */


use app\enums\TextLinkEnum;
use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>
<div class="card shadow">
    <div class="card-body d-flex flex-column gap-3">
        <div class="d-flex justify-content-between flex-wrap">

            <div class="d-inline-flex flex-column align-items-baseline">
                <?= Html::tag('span', $model->barang->part_number . ' | ' . $model->barang->nama, ['class' => '']) ?>

                <div class="d-inline-flex gap-2">
                    <?= Html::tag('small', $model->quantity . ' ' . $model->satuan->nama, [
                        'class' => 'badge bg-info rounded-pill'
                    ]) ?>
                    <?= Html::tag('small', $model->barang->tipePembelian->nama, [
                        'class' => 'badge text-bg-warning rounded-pill'
                    ]) ?>
                </div>
            </div>
            <div>
                <?php if (empty($model->materialRequisitionDetailPenawarans)) : ?>
                    <?php
                    echo Html::a('<i class="bi bi-plus-circle"></i> Buat Penawaran',
                        ['material-requisition/create-penawaran', 'materialRequisitionDetailId' => $model->id], [
                            'class'          => 'btn btn-success mb-2',
                            'data-bs-toggle' => 'modal',
                            'data-bs-target' => '#modal-penawaran-harga',
                        ]);
                    ?>
                <?php else: ?>
                    <div class="mb-3 d-inline-flex gap-2">
                        <?php
                        echo Html::a(TextLinkEnum::UPDATE->value . ' Penawaran',
                            ['material-requisition/update-penawaran', 'materialRequisitionDetailId' => $model->id], [
                                'class'          => 'btn btn-outline-primary',
                                'data-bs-toggle' => 'modal',
                                'data-bs-target' => '#modal-penawaran-harga',
                            ]);
                        ?>

                        <?php
                        /* Server-side PJAX delete: gunakan form POST dengan data-pjax agar disubmit via PJAX */
                        echo Html::beginForm(['material-requisition/delete-penawaran', 'materialRequisitionDetailId' => $model->id], 'post', [
                            'data' => ['pjax' => 1]
                        ]);
                        echo Html::submitButton(TextLinkEnum::DELETE->value . ' Penawaran', [
                            'class' => 'btn btn-outline-danger',
                            'data'  => [
                                'confirm' => 'Anda yakin membatalkan penawaran untuk item ini ?'
                            ]
                        ]);
                        echo Html::endForm();
                        ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <?php if (!empty($model->description)): ?>
            <p class="card-text text-muted">Penawaran Harga: <?= $model->description ?></p>
        <?php endif; ?>


        <div class="table-responsive">
            <?php
            echo GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query'      => $model->getMaterialRequisitionDetailPenawarans(),
                    'sort'       => false,
                    'pagination' => false
                ]),
                'layout'       => '{items}',
                'columns'      => [
                    [
                        'class' => SerialColumn::class
                    ],
                    [
                        'class'     => DataColumn::class,
                        'attribute' => 'vendor_id',
                        'value'     => 'vendor.nama'
                    ],
                    [
                        'class'     => DataColumn::class,
                        'attribute' => 'mata_uang_id',
                        'value'     => 'mataUang.nama'
                    ],
                    [
                        'class'          => DataColumn::class,
                        'attribute'      => 'quantity_pesan',
                        'format'         => ['decimal', 2],
                        'contentOptions' => [
                            'class' => 'text-end'
                        ]
                    ],
                    [
                        'class'          => DataColumn::class,
                        'attribute'      => 'harga_penawaran',
                        'header'         => 'Harga Per Item',
                        'format'         => ['decimal', 2],
                        'contentOptions' => [
                            'class' => 'text-end'
                        ]
                    ],
                    [
                        'attribute' => 'statusLabel',
                        'label'     => 'Status',
                        'format'    => 'raw'
                    ],
                    [
                        'class'     => DataColumn::class,
                        'attribute' => 'purchase_order_id',
                        'value'     => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return empty($model->purchaseOrder) ? '' : $model->purchaseOrder->nomor;
                        }
                    ],
                ]
            ]);
            ?>
        </div>
    </div>
</div>

