<?php


/* @var $this View */
/* @see \app\controllers\TandaTerimaBarangController::actionExpandItem() */

/* @var $model TandaTerimaBarang */

use app\models\MaterialRequisitionDetailPenawaran;
use app\models\TandaTerimaBarang;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\web\View;

?>

<div class="tanda-terima-barang-item">
    <?php
    try {
        echo GridView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => $model->getMaterialRequisitionDetailPenawarans(),
                'pagination' => false,
                'sort' => false
            ]),
            'headerRowOptions' => [
                'class' => 'table table-primary'
            ],
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => SerialColumn::class
                ],
                [
                    'header' => 'Status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var MaterialRequisitionDetailPenawaran $model */
                        return $model->getStatusPenerimaanInHtmlLabel();
                    }
                ],
                [
                    'header' => 'M.R',
                    'value' => function ($model) {
                        /** @var MaterialRequisitionDetailPenawaran $model */
                        return $model->materialRequisitionDetail->materialRequisition->nomor;
                    }
                ],
                [
                    'header' => 'Vendor',
                    'value' => function ($model) {
                        /** @var MaterialRequisitionDetailPenawaran $model */
                        return $model->vendor->nama;
                    }
                ],
                [
                    'header' => 'Quantity Pesan',
                    'value' => function ($model) {
                        /** @var MaterialRequisitionDetailPenawaran $model */
                        return $model->quantity_pesan;
                    },
                    'contentOptions' => [
                        'class' => 'text-end'
                    ]
                ],
                [
                    'header' => 'Harga Penawaran',
                    'value' => function ($model) {
                        /** @var MaterialRequisitionDetailPenawaran $model */
                        return $model->harga_penawaran;
                    },
                    'format' => ['decimal', 2],
                    'contentOptions' => [
                        'class' => 'text-end'
                    ]
                ],
                [
                    'header' => 'Quantity Terima',
                    'value' => function ($model) {
                        /** @var MaterialRequisitionDetailPenawaran $model */
                        return $model->getTotalQuantitySudahDiTerima();
                    },
                    'contentOptions' => [
                        'class' => 'text-end'
                    ],
                    'format' => ['decimal', 2]
                ],
                [
                    'header' => 'Satuan',
                    'value' => function ($model) {
                        /** @var MaterialRequisitionDetailPenawaran $model */
                        return $model->materialRequisitionDetail->satuan->nama;
                    }
                ]
            ]
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>
</div>