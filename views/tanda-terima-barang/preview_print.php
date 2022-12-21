<?php

use app\models\TandaTerimaBarang;
use app\models\TandaTerimaBarangDetail;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\web\View;


/* @var $this View */
/* @var $model TandaTerimaBarang */
/* @see \app\controllers\TandaTerimaBarangController::actionPrint() */

?>

<div class="tanda-terima-barang-print">
    <h1 class="text-center">Tanda Terima Barang</h1>

    <div style="width: 100%">
        <div class="mb-1" style=" float: left; width: 45%; padding-right: 1em">
            <div class="border-1" style="min-height: 1.6cm; max-height: 3.6cm; padding: .5em">
                Telah terima dari: <br/>
               <?= $model->purchaseOrder->vendor->nama ?>
            </div>

            <p class="font-weight-bold">
                Status : <?= $model->getStatusPesananYangSudahDiterimaInHtmlFormat() ?>
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
       <?php if (!empty($model->tandaTerimaBarangDetails)) : ?>
          <?= GridView::widget([
             'dataProvider' => new ActiveDataProvider([
                'query' => $model->getTandaTerimaBarangDetails(),
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
                      /** @var TandaTerimaBarangDetail $model */
                      return $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->part_number;
                   }
                ],
                [
                   'class' => DataColumn::class,
                   'vAlign' => 'middle',
                   'header' => 'IFT Number',
                   'value' => function ($model) {
                      /** @var TandaTerimaBarangDetail $model */
                      return $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->ift_number;
                   }
                ],
                [
                   'class' => DataColumn::class,
                   'vAlign' => 'middle',
                   'header' => 'Merk',
                   'headerOptions' => [
                      'class' => 'border-end-1 '
                   ],
                   'contentOptions' => [
                      'class' => 'border-top-1 border-end-1'
                   ],
                   'value' => function ($model) {
                      /** @var TandaTerimaBarangDetail $model */
                      return $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->merk_part_number;
                   }
                ],
                [
                   'class' => DataColumn::class,
                   'vAlign' => 'middle',
                   'header' => 'Description',
                   'contentOptions' => [
                      'class' => 'border-top-1'
                   ],
                   'headerOptions' => [
                      'class' => 'border-0'
                   ],
                   'value' => function ($model) {
                      /** @var TandaTerimaBarangDetail $model */
                      return $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->nama;
                   }
                ],
//                    [
//                        'class' => DataColumn::class,
//                        'vAlign' => 'middle',
//                        'header' => 'Order',
//                        'value' => function ($model) {
//                            /** @var TandaTerimaBarangDetail $model */
//                            return $model->materialRequisitionDetailPenawaran->quantity_pesan;
//                        },
//                        'contentOptions' => [
//                            'class' => 'text-end border-end-0'
//                        ],
//                        'headerOptions' => [
//                            'class' => 'text-end border-end-0'
//                        ]
//                    ],
                [
                   'class' => DataColumn::class,
                   'vAlign' => 'middle',
                   'header' => '',
                   'value' => function ($model) {
                      /** @var TandaTerimaBarangDetail $model */
                      return $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->satuan->nama;
                   },
                   'contentOptions' => [
                      'class' => 'text-end border-top-1 border-start-0'
                   ],
                   'headerOptions' => [
                      'class' => 'text-end border-0'
                   ],
                ],
                [
                   'class' => DataColumn::class,
                   'header' => 'Actual',
                   'format' => ['decimal', 2],
                   'vAlign' => 'middle',
                   'value' => function ($model) {
                      /** @var TandaTerimaBarangDetail $model */
                      return $model->quantity_terima;
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
                      /** @var TandaTerimaBarangDetail $model */
                      return $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->satuan->nama;
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
                      /** @var TandaTerimaBarangDetail $model */
                      return $model->materialRequisitionDetailPenawaran->getStatusPenerimaanInHtmlLabel('small');
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
                <td rowspan="3" style="width: 30%">
                    Remarks<br/>
                   <?php $dataAngsur = $model->purchaseOrder->nomorTandaTerimaColumns ?>
                   <?php if (count($dataAngsur) > 1) : ?>
                       <p>By Sistem: P.O diangsur beberapa kali tanda terima:
                          <?php foreach ($dataAngsur as $nomorTandaTerimaBarang) : ?>
                             <?= $nomorTandaTerimaBarang . '<br/>' ?>
                          <?php endforeach; ?>
                       </p>

                   <?php endif ?>
                </td>
                <td class="text-center text-nowrap" style="height: 100px; white-space: nowrap">Received By</td>
                <td class="text-center text-nowrap" style="height: 100px">Messenger</td>
                <td class="text-center text-nowrap">Acknowledge By</td>
                <td class="text-center text-nowrap">Vendor</td>
            </tr>

            <tr class="text-center">
                <td></td>
                <td class="text-center text-nowrap"><?= $model->acknowledgeBy->nama ?></td>
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


</div>