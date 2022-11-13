<?php

/* @var $this yii\web\View */
/* @var $model app\models\MaterialRequisitionDetailPenawaran */

/* @var $index int */

use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\DetailView;

?>

<div class="card mb-4 border-1 item">

    <div class="card-body">
        <strong>
            <?= ($index + 1) ?>
        </strong>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <?php
                try {
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            // 'id',
                            [
                                'attribute' => 'material_requisition_detail_id',
                                'value' => $model->materialRequisitionDetail->materialRequisition->nomor
                            ],
                            [
                                'attribute' => 'vendor_id',
                                'value' => $model->vendor->nama
                            ],
                            [
                                'attribute' => 'mata_uang_id',
                                'value' => $model->mataUang->singkatan
                            ],
                            'quantity_pesan',
                            [
                                'attribute' => 'harga_penawaran',
                                'value' => Yii::$app->formatter->asDecimal($model->harga_penawaran, 2)
                            ],
                            [
                                'attribute' => 'status_id',
                                'value' => $model->status->key
                            ],
                            [
                                'attribute' => 'purchase_order_id',
                                'value' => $model->purchaseOrder->nomor
                            ],
                            // 'tanda_terima_barang_id',
                            // 'created_at',
                            // 'updated_at',
                            // 'created_by',
                            // 'updated_by',
                        ],
                    ]);
                } catch (Throwable $e) {
                    echo $e->getMessage();
                }
                ?>
            </div>
            <div class="col-sm-12 col-md-6">
                <p class="font-weight-bold"><i class="bi bi-bag-check-fill"></i>
                    History penerimaan barang: <?= $model->getStatusPenerimaanInHtmlLabel() ?>
                </p>
                <?php try {
                    echo GridView::widget([
                        'panel' => false,
                        'bordered' => false,
                        'striped' => false,
                        'headerContainer' => [],
                        'dataProvider' => new ActiveDataProvider([
                            'query' => $model->getTandaTerimaBarangDetails(),
                            'sort' => false,
                            'pagination' => false
                        ]),
                        'tableOptions' => [
                            'class' => 'table table-bordered mb-0'
                        ],
                        'layout' => '{items}',
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn',
                                'contentOptions' => [
                                    'style' => [
                                        'width' => '2px'
                                    ]
                                ],
                            ],
                            // [
                            // 'class'=>'\yii\grid\DataColumn',
                            // 'attribute'=>'id',
                            // ],
                            // [
                            // 'class'=>'\yii\grid\DataColumn',
                            // 'attribute'=>'material_requisition_detail_penawaran_id',
                            // ],
                            [
                                'class' => '\yii\grid\DataColumn',
                                'attribute' => 'tanggal',
                            ],
                            [
                                'class' => '\yii\grid\DataColumn',
                                'attribute' => 'quantity_terima',
                                'contentOptions' => [
                                    'class' => 'text-end'
                                ],
                                'headerOptions' => [
                                    'class' => 'text-end'
                                ]
                            ],
                        ]
                    ]);
                } catch (Exception $e) {
                    echo $e->getMessage();
                } catch (Throwable $e) {
                    echo $e->getMessage();
                }
                ?>
            </div>
        </div>
    </div>
</div>