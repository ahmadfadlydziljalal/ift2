<?php

/* @var $this yii\web\View */
/* @var $model app\models\ClaimPettyCash */

/* @var $index int */

use app\models\ClaimPettyCashNotaDetail;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

?>

<?php try {
    echo GridView::widget([
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
                        'content' => ': ' . $model->nomor,
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
        'panel' => false,
        'bordered' => false,
        'striped' => false,
        'headerContainer' => [],
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getClaimPettyCashNotaDetails(),
            'sort' => false,
            'pagination' => false
        ]),
        'tableOptions' => [
            'class' => 'mb-0'
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
            // 'attribute'=>'claim_petty_cash_nota_id',
            // ],
            [
                'class' => '\yii\grid\DataColumn',
                'attribute' => 'tipe_pembelian_id',
                'value' => 'tipePembelian.nama',
                'label' => 'Tipe'
            ],
            [
                'class' => '\yii\grid\DataColumn',
                'attribute' => 'Part Number',
                'value' => 'barang.part_number'
            ],
            [
                'class' => '\yii\grid\DataColumn',
                'label' => 'IFT Number',
                'value' => 'barang.ift_number'
            ],
            [
                'class' => '\yii\grid\DataColumn',
                'label' => 'Merk',
                'value' => 'barang.merk_part_number'
            ],
            [
                'class' => '\yii\grid\DataColumn',
                'attribute' => 'description',
                'format' => 'raw',
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
                'class' => '\yii\grid\DataColumn',
                'attribute' => 'quantity',
                'label' => 'Qty'
            ],
            [
                'class' => '\yii\grid\DataColumn',
                'attribute' => 'satuan_id',
                'label' => 'Unit',
                'value' => 'satuan.nama'
            ],
            [
                'class' => '\yii\grid\DataColumn',
                'attribute' => 'harga',
                'label' => 'Price',
                'format' => ['decimal', 2],
                'contentOptions' => [
                    'class' => 'text-end'
                ]
            ],
            [
                'attribute' => 'subTotal',
                'format' => ['decimal', 2],
                'contentOptions' => [
                    'class' => 'text-end'
                ]
            ]
        ]
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
} catch (Throwable $e) {
    echo $e->getMessage();
}
?>

<hr/>