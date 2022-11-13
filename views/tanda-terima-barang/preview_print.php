<?php

use app\models\MaterialRequisitionDetailPenawaran;
use app\models\TandaTerimaBarang;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\web\View;


/* @var $this View */
/* @var $model TandaTerimaBarang */
/* @see \app\controllers\TandaTerimaBarangController */

?>

<div class="tanda-terima-barang-print">
    <h1 class="text-center">Tanda Terima Barang</h1>

    <div style="width: 100%">
        <div class="mb-1" style=" float: left; width: 45%; padding-right: 2em">
            <div class="border-1" style="min-height: 1.6cm; max-height: 3.6cm; padding: .5em">
                Telah terima dari: <br/>
                <?= $model->purchaseOrder->vendor->nama ?>
            </div>

            <p class="font-weight-bold">
                Status : <?= $model->getStatusInHtmlLabel() ?>
            </p>
        </div>

        <div class="mb-1" style=" float: right; width: 51%">
            <table class="table">
                <tbody>
                <tr>
                    <td>No.</td>
                    <td>:</td>
                    <td><?= $model->nomor ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td><?= Yii::$app->formatter->asDate($model->tanggal) ?></td>
                </tr>
                <tr>
                    <td>Page</td>
                    <td>:</td>
                    <td><span id="page-number"></span></td>
                </tr>
                <tr>
                    <td>Ref No. P.O</td>
                    <td>:</td>
                    <td><?= $model->purchaseOrder->nomor ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="clear: both"></div>

    <div class="mb-1" style="width: 100%">
        <?php if (!empty($model->materialRequisitionDetailPenawarans)) : ?>
            <?= GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getMaterialRequisitionDetailPenawarans(),
                    'pagination' => false,
                    'sort' => false
                ]),
                'layout' => '{items}',
                'columns' => [
                    [
                        'class' => SerialColumn::class
                    ],
                    [
                        'class' => DataColumn::class,
                        'vAlign' => 'middle',
                        'header' => 'Part Number',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->barang->part_number;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'vAlign' => 'middle',
                        'header' => 'IFT Number',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->barang->ift_number;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'vAlign' => 'middle',
                        'header' => 'Merk',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->barang->merk_part_number;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'vAlign' => 'middle',
                        'header' => 'Description',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->barang->nama;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'vAlign' => 'middle',
                        'header' => 'Order',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->quantity_pesan;
                        },
                        'contentOptions' => [
                            'class' => 'text-end border-end-0'
                        ],
                        'headerOptions' => [
                            'class' => 'text-end border-end-0'
                        ]
                    ],
                    [
                        'class' => DataColumn::class,
                        'vAlign' => 'middle',
                        'header' => '',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->satuan->nama;
                        },
                        'contentOptions' => [
                            'class' => 'text-end border-start-0'
                        ],
                        'headerOptions' => [
                            'class' => 'text-end border-start-0'
                        ],
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Actual',
                        'format' => ['decimal', 2],
                        'vAlign' => 'middle',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->totalQuantitySudahDiTerima;
                        },
                        'contentOptions' => [
                            'class' => 'text-end border-end-0'
                        ],
                        'headerOptions' => [
                            'class' => 'text-end border-end-0'
                        ]
                    ],
                    [
                        'class' => DataColumn::class,
                        'vAlign' => 'middle',
                        'header' => '',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->satuan->nama;
                        },
                        'contentOptions' => [
                            'class' => 'text-end border-start-0'
                        ],
                        'headerOptions' => [
                            'class' => 'text-end border-start-0'
                        ],
                    ],
                    [
                        'class' => DataColumn::class,
                        'vAlign' => 'middle',
                        'header' => 'Status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->getStatusPenerimaanInHtmlLabel('small');
                        },
                        'contentOptions' => [
                            'class' => 'text-end'
                        ],
                        'headerOptions' => [
                            'class' => 'text-end'
                        ],
                    ],
                ]
            ]) ?>
        <?php endif ?>
    </div>

    <div style="clear: both"></div>

    <div class="mb-1" style="width: 100%">
        <table class="table table-grid-view table-bordered">
            <tbody>
            <tr class="text-center">
                <td rowspan="3" style="width: 40%">Remarks</td>
                <td style="height: 100px; white-space: nowrap">Received By</td>
                <td style="height: 100px">Messenger</td>
                <td style="white-space: nowrap">Acknowledge By</td>
                <td style="white-space: nowrap">Vendor</td>
            </tr>

            <tr class="text-center">
                <td></td>
                <td style="white-space: nowrap"><?= $model->acknowledgeBy->nama ?></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 1em"></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="clear: both"></div>
    <p>** Jika barang yang diterima belum sesuai, harap supplier atau vendor membawa tanda terima ini lagi untuk tanda
        terima selanjutnya.</p>
</div>