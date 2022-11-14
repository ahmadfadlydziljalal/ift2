<?php


/* @var $this View */
/* @see \app\controllers\TandaTerimaBarangController::actionExpandItem() */

/* @var $model TandaTerimaBarang */

use app\models\TandaTerimaBarang;
use app\models\TandaTerimaBarangDetail;
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
                'query' => $model->getTandaTerimaBarangDetails(),
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
                        /** @var TandaTerimaBarangDetail $model */
                        return $model->materialRequisitionDetailPenawaran->getStatusPenerimaanInHtmlLabel();
                    }
                ],
                [
                    'header' => 'M.R',
                    'value' => function ($model) {
                        /** @var TandaTerimaBarangDetail $model */
                        return $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->materialRequisition->nomor;
                    }
                ],
                [
                    'header' => 'Vendor',
                    'value' => function ($model) {
                        /** @var TandaTerimaBarangDetail $model */
                        return $model->materialRequisitionDetailPenawaran->vendor->nama;
                    }
                ],
                [
                    'header' => 'Quantity Pesan',
                    'value' => function ($model) {
                        /** @var TandaTerimaBarangDetail $model */
                        return $model->materialRequisitionDetailPenawaran->quantity_pesan;
                    },
                    'contentOptions' => [
                        'class' => 'text-end'
                    ]
                ],
                [
                    'header' => 'Harga Penawaran',
                    'value' => function ($model) {
                        /** @var TandaTerimaBarangDetail $model */
                        return $model->materialRequisitionDetailPenawaran->harga_penawaran;
                    },
                    'format' => ['decimal', 2],
                    'contentOptions' => [
                        'class' => 'text-end'
                    ]
                ],
                [
                    'header' => 'Quantity Terima',
                    'value' => function ($model) {
                        /** @var TandaTerimaBarangDetail $model */
                        return $model->quantity_terima;
                    },
                    'contentOptions' => [
                        'class' => 'text-end'
                    ],
                    'format' => ['decimal', 2]
                ],
                [
                    'header' => 'Satuan',
                    'value' => function ($model) {
                        /** @var TandaTerimaBarangDetail $model */
                        return $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->satuan->nama;
                    }
                ]
            ]
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>
</div>