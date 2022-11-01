<?php

/* @var $this yii\web\View */
/* @var $model app\models\ClaimPettyCashNota */

/* @var $index int */

use app\models\ClaimPettyCashNota;
use app\models\ClaimPettyCashNotaDetail;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;

?>

<?php try {
    echo GridView::widget([
        'moduleId' => 'gridviewPrint',
        'panel' => false,
        'tableOptions' => [
            'class' => 'mb-0'
        ],
        'bordered' => false,
        'striped' => false,
        'headerContainer' => [],
        'layout' => '{items}',
        'pageSummaryRowOptions' => [
            'class' => ''
        ],
        'pageSummaryContainer' => [
            'class' => 'tbody-summary-container'
        ],
        'beforeHeader' => [
            [
                'columns' => [
                    [
                        'content' => 'Nomor Nota : ',
                        'options' => [
                            'colspan' => 3,
                            'class' => 'text-start border-0'
                        ],
                    ],
                    [
                        'content' => ': ' . $model->nomor . " | " . Yii::$app->formatter->asDate($model->tanggal_nota),
                        'options' => [
                            'colspan' => 7,
                            'class' => 'text-start border-0'
                        ],

                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'content' => 'Vendor',
                        'options' => [
                            'colspan' => 3,
                            'class' => 'text-start border-0 pb-2'
                        ],
                    ],
                    [
                        'content' => ': ' . $model->vendor->nama,
                        'options' => [
                            'colspan' => 7,
                            'class' => 'text-start border-0 pb-2'
                        ],
                    ],
                ],
            ],
        ],
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getClaimPettyCashNotaDetails(),
            'sort' => false,
            'pagination' => false
        ]),
//        'rowOptions' => [
//            'class' => 'text-wrap'
//        ],
        'columns' => [
            [
                'class' => SerialColumn::class,
                'contentOptions' => [
                    'style' => [
                        'width' => '2px'
                    ]
                ],
//                'pageSummary' => function () use ($model) {
//                    /** @var ClaimPettyCashNota $model */
//                    return "Terbilang: " . Yii::$app->formatter->asSpellout($model->sumDetails);
//                },
                'pageSummaryOptions' => [
                    'colspan' => 8,
                    'class' => 'border-0'
                ]
            ],
            [
                'class' => DataColumn::class,
                'attribute' => 'tipe_pembelian_id',
                'value' => 'barang.tipePembelian.nama',
                'label' => 'Tipe',

            ],
            [
                'class' => DataColumn::class,
                'attribute' => 'Part Number',
                'value' => 'barang.part_number'
            ],
            [
                'class' => DataColumn::class,
                'label' => 'IFT Number',
                'value' => 'barang.ift_number'
            ],
            [
                'class' => DataColumn::class,
                'label' => 'Merk',
                'value' => 'barang.merk_part_number'
            ],
            [
                'class' => DataColumn::class,
                'attribute' => 'description',
                'format' => 'raw',
                'contentOptions' => [
                    'class' => 'text-wrap'
                ],
                'value' => function ($model) {
                    $string = '';
                    /** @var ClaimPettyCashNotaDetail $model */
                    if (!empty($model->barang_id)) {
                        $string .= $model->barang->nama . '<br/>';
                    }
                    $string .= $model->description;
                    return $string;
                }
            ],
            [
                'class' => DataColumn::class,
                'attribute' => 'quantity',
                'label' => 'Qty'
            ],
            [
                'class' => DataColumn::class,
                'attribute' => 'satuan_id',
                'label' => 'Unit',
                'value' => 'satuan.nama'
            ],
            [
                'class' => DataColumn::class,
                'attribute' => 'harga',
                'label' => 'Price',
                'format' => ['decimal', 2],
                'contentOptions' => [
                    'class' => 'text-end'
                ],
                'pageSummary' => function () {
                    return "Total: ";
                },
            ],
            [
                'class' => DataColumn::class,
                'attribute' => 'subTotal',
                'format' => ['decimal', 2],
                'contentOptions' => [
                    'class' => 'text-end'
                ],
                'pageSummary' => function () use ($model) {
                    /** @var ClaimPettyCashNota $model */
                    return Yii::$app->formatter->asDecimal($model->sumDetails, 2);
                },
                'pageSummaryOptions' => [
                    'class' => 'text-end'
                ]
            ]
        ],
        'showPageSummary' => true,
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
} catch (Throwable $e) {
    echo $e->getMessage();
}
?>