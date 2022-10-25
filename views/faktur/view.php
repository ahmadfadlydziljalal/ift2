<?php

use app\models\FakturDetail;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use mdm\admin\components\Helper;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Faktur */

$this->title = $model->nomor_faktur;
$this->params['breadcrumbs'][] = ['label' => 'Fakturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faktur-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

            <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a("<i class='bi bi-printer'></i>" . ' Print', ['pdf', 'id' => $model->id], [
                'class' => 'btn btn-outline-primary',
                'target' => '_blank'
            ]) ?>
            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?php
            if (Helper::checkRoute('delete')) :
                echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
            endif;
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col col-lg-7">
            <?php
            try {
                echo DetailView::widget([
                    'model' => $model,
                    'options' => [
                        'class' => 'table table-bordered table-detail-view'
                    ],
                    'attributes' => [
                        'tanggal_faktur:date',
                        'nomor_faktur',
                        'nomor_purchase_order',
                        [
                            'attribute' => 'jenis_transaksi_id',
                            'value' => $model->jenisTransaksi->nama
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
        $sumSubtotal = $model->sumSubtotal;
        echo !empty($model->fakturDetails) ?
            GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getFakturDetails()
                        ->joinWith('barang', false)
                        ->joinWith('satuan', false)
                ]),
                'columns' => [
                    // [
                    // 'class'=>'\yii\grid\DataColumn',
                    // 'attribute'=>'id',
                    // ],
                    // [
                    // 'class'=>'\yii\grid\DataColumn',
                    // 'attribute'=>'faktur_id',
                    // ],
                    [
                        'class' => SerialColumn::class,
                        'width' => '1%',
                        'header' => 'No.',
                        'contentOptions' => [
                            'class' => 'text-end'
                        ]
                    ],
                    [
                        'class' => 'kartik\grid\DataColumn',
                        'label' => 'Part Number',
                        'width' => '13rem',
                        'attribute' => 'barang_id',
                        'value' => function ($model) {
                            /** @var FakturDetail $model */
                            return $model->barang->part_number;
                        },
                        'headerOptions' => [
                            'class' => 'text-center'
                        ],
                        'pageSummary' => function () use ($sumSubtotal) {
                            return Html::tag('span', 'Terbilang: ' . Yii::$app->formatter->asSpellout($sumSubtotal), [
                                'font-weight' => 'bold'
                            ]);
                        },
                        'pageSummaryOptions' => [
                            'colspan' => 5,

                        ],
                    ],
                    [
                        'class' => 'kartik\grid\DataColumn',
                        'attribute' => 'barang_id',
                        'label' => 'Description',
                        'value' => function ($model) {
                            /** @var FakturDetail $model */
                            return $model->barang->nama;
                        },
                        'headerOptions' => [
                            'class' => 'text-center'
                        ],
                        'contentOptions' => [
                            'class' => 'text-nowrap'
                        ]
                    ],
                    [
                        'class' => 'kartik\grid\DataColumn',
                        'attribute' => 'quantity',
                        'label' => 'Qty',
                        'contentOptions' => [
                            'class' => 'text-nowrap'
                        ],
                        'value' => function ($model) {
                            /** @var FakturDetail $model */
                            return $model->quantity . ' ' . $model->satuan->nama;
                        },
                        'headerOptions' => [
                            'class' => 'text-center'
                        ],
                    ],
                    [
                        'class' => 'kartik\grid\DataColumn',
                        'headerOptions' => [
                            'class' => 'text-end border-end-0 '
                        ],
                        'contentOptions' => [
                            'class' => 'text-end border-end-0 '
                        ],
                        'value' => function ($model) {
                            return Yii::$app->getFormatter()->currencyCode;
                        },
                        'pageSummaryOptions' => [
                            'class' => 'text-end border-end-0 '
                        ]
                    ],
                    [
                        'class' => 'kartik\grid\DataColumn',
                        'attribute' => 'harga_barang',
                        'label' => 'Unit Price',
                        'headerOptions' => [
                            'class' => 'text-end text-nowrap border-start-0'
                        ],
                        'contentOptions' => [
                            'class' => 'text-end border-start-0'
                        ],
                        'format' => ['decimal', 2],
                        'pageSummary' => false,
                        'pageSummaryOptions' => [
                            'class' => 'text-end border-start-0'
                        ]
                    ],
                    [
                        'class' => 'kartik\grid\DataColumn',
                        'headerOptions' => [
                            'class' => 'text-end border-end-0 '
                        ],
                        'contentOptions' => [
                            'class' => 'text-end border-end-0 '
                        ],
                        'value' => function ($model) {
                            return Yii::$app->getFormatter()->currencyCode;
                        },
                        'pageSummary' => function ($summary, $data) {
                            return Yii::$app->getFormatter()->currencyCode;
                        },
                        'pageSummaryOptions' => [
                            'class' => 'text-end border-end-0 '
                        ]
                    ],
                    [
                        'class' => 'kartik\grid\DataColumn',
                        'label' => 'Subtotal',
                        'headerOptions' => [
                            'class' => 'text-end border-start-0'
                        ],
                        'contentOptions' => [
                            'class' => 'text-end border-start-0'
                        ],
                        'value' => function ($model) {
                            /** @var FakturDetail $model */
                            return $model->subTotal;
                        },
                        'format' => ['decimal', 2],
                        'pageSummary' => true,
                        'pageSummaryOptions' => [
                            'class' => 'text-end border-start-0'
                        ]
                    ]
                ],
                'showPageSummary' => true
            ]) :
            Html::tag("p", 'Faktur Detail tidak tersedia', [
                'class' => 'text-warning font-weight-bold p-3'
            ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</div>