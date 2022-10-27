<?php

use app\enums\TextLinkEnum;
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
            <?= Html::a(TextLinkEnum::BUAT_LAGI->value, ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="d-flex flex-row gap-1 mb-3">

        <?= Html::a(TextLinkEnum::KEMBALI->value, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a(TextLinkEnum::PRINT->value, ['print', 'id' => $model->id], [
            'class' => 'btn btn-outline-primary',
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
                'reference_number',
                'remarks:nText',
                'approved_by',
                'acknowledge_by',
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

    <?php try {
        echo !empty($model->purchaseOrderDetails) ?
            GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getPurchaseOrderDetails(),
                    'sort' => false
                ]),
                'columns' => [
                    [
                        'class' => SerialColumn::class
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Part Number',
                        'value' => 'barang.part_number',
                        'pageSummaryOptions' => [
                            'colspan' => 6
                        ],
                        'pageSummary' => function ($summary, $data, $widget) use ($model) {
                            return "Spell out: " . Yii::$app->formatter->asSpellout($model->getSumSubTotal());
                        },
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'IFT Number',
                        'value' => 'barang.ift_number'
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Merk',
                        'value' => 'barang.merk_part_number'
                    ],
                    [
                        'class' => DataColumn::class,
                        'header' => 'Description',
                        'value' => 'barang.nama'
                    ],
                    [
                        'class' => DataColumn::class,
                        'attribute' => 'quantity',
                        'format' => ['decimal', 2],
                        'contentOptions' => [
                            'class' => 'text-end'
                        ]
                    ],
                    [
                        'class' => DataColumn::class,
                        'attribute' => 'satuan_id',
                        'value' => 'satuan.nama'
                    ],
                    [
                        'class' => DataColumn::class,
                        'attribute' => 'price',
                        'format' => ['decimal', 2],
                        'contentOptions' => [
                            'class' => 'text-end'
                        ],
                        'pageSummary' => 'Total: ',
                        'pageSummaryOptions' => [
                            'class' => 'text-end'
                        ]
                    ],
                    [
                        'class' => DataColumn::class,
                        'attribute' => 'subtotal',
                        'format' => ['decimal', 2],
                        'contentOptions' => [
                            'class' => 'text-end'
                        ],
                        'pageSummary' => function ($summary, $data, $widget) use ($model) {
                            return Yii::$app->formatter->asDecimal($model->getSumSubTotal(), 2);
                        },
                        'pageSummaryOptions' => [
                            'class' => 'text-end'
                        ]
                        //'pageSummary' => true,
                        //'pageSummaryFormat' => ['decimal', 2]
                    ],
                ],
                'showPageSummary' => true,
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