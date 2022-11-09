<?php

use app\enums\TextLinkEnum;
use app\models\MaterialRequisitionDetailPenawaran;
use app\models\PurchaseOrder;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use mdm\admin\components\Helper;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchase-order-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0 gap-1">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center gap-2">
            <?= Html::a(TextLinkEnum::LIST->value, ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a(TextLinkEnum::BUAT_LAGI->value, ['purchase-order/before-create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="d-flex flex-row gap-1 mb-3">

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
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-6">
            <?php
            try {
                echo DetailView::widget([
                    'model' => $model,
                    'options' => [
                        'class' => 'table table-bordered table-detail-view'
                    ],
                    'attributes' => [
                        'nomor',
                        [
                            'attribute' => 'vendor_id',
                            'value' => $model->vendor->nama
                        ],
                        'tanggal:date',
                        'remarks:nText',
                        [
                            'attribute' => 'approved_by_id',
                            'value' => $model->approvedBy->nama
                        ],
                        [
                            'attribute' => 'acknowledge_by_id',
                            'value' => $model->acknowledgeBy->nama
                        ],
                        [
                            'label' => 'Created By',
                            'value' => function ($model) {
                                /** @var PurchaseOrder $model */
                                return !empty($model->userKaryawan)
                                    ? $model->userKaryawan['nama']
                                    : $model->usernameWhoCreated;
                            }
                        ],
                    ],
                ]);
            } catch (Throwable $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>


    <?php try {
        echo !empty($model->materialRequisitionDetailPenawarans) ?
            GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getMaterialRequisitionDetailPenawarans(),
                    'sort' => false
                ]),
                'columns' => [
                    [
                        'class' => SerialColumn::class
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Material Requisition',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->materialRequisition->nomor;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Tipe Pembelian',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->barang->tipePembelian->nama;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Barang',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->barang->nama;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Part Number',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->barang->part_number;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'IFT Number',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->barang->ift_number;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Merk',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->barang->merk_part_number;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Description',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->description;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Qty',
                        'contentOptions' => [
                            'class' => 'text-end'
                        ],
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->quantity;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Satuan',
                        'value' => function ($model) {
                            /** @var MaterialRequisitionDetailPenawaran $model */
                            return $model->materialRequisitionDetail->satuan->nama;
                        }
                    ],
                    [
                        'class' => DataColumn::class,
                        'attribute' => 'harga_penawaran',
                        'format' => ['decimal', 2],
                        'contentOptions' => [
                            'class' => 'text-end'
                        ]
                    ]
                ],
                'layout' => '{items}'

            ]) :
            Html::tag("p", 'Purchase Order Detail tidak tersedia', [
                'class' => 'text-warning font-weight-bold p-3'
            ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</div>