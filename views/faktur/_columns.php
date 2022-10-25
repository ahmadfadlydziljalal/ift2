<?php

use app\models\Card;
use app\models\JenisTransaksi;
use app\models\Rekening;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Html;

return [
    [
        'class' => 'yii\grid\SerialColumn',
    ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'id',
    // 'format'=>'text',
    // ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'toko_saya_id',
        'value' => 'tokoSaya.kode',
        'filter' => Card::find()->map(Card::GET_ONLY_TOKO_SAYA)
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'card_id',
        'value' => 'card.singkatanNama',
        'filter' => Card::find()->map(Card::GET_APART_FROM_TOKO_SAYA)
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'tanggal_faktur',
        'format' => 'date',
        'filterType' => GridView::FILTER_DATE,
        'filterWidgetOptions' => [
            'type' => DatePicker::TYPE_INPUT,
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'autoclose' => true,
                'todayHighlight' => true,
            ]
        ],
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nomor_faktur',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nomor_purchase_order',
        'format' => 'text',
        'header' => 'P.O'
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'jenis_transaksi_id',
        'format' => 'text',
        'filter' => JenisTransaksi::find()->map(),
        'value' => 'jenisTransaksi.nama',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'rekening_id',
        'filter' => Rekening::find()->map(),
        'value' => 'rekening.atas_nama',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'value' => function ($model) {
            return Yii::$app->getFormatter()->currencyCode;
        },
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'label' => 'Total',
        'contentOptions' => [
            'class' => 'text-end'
        ],
        'format' => ['decimal', '2'],
        'value' => function ($model) {
            return $model->sumSubtotal;
        }
    ],
    [
        'class' => 'app\components\grid\ActionColumn',
        'template' => '{preview-print} {update} {view} {delete}',
        'buttons' => [
            'preview-print' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer-fill"></i>', ['faktur/preview-print', 'id' => $model->id], [
                    'class' => 'preview-print text-success'
                ]);
            },
            /*'pdf' => function ($url, $model) {
                return Html::a('<i class="bi bi-file-pdf-fill"></i>', ['faktur/pdf', 'id' => $model->id], [
                    'target' => '_blank'
                ]);
            },*/
        ],
    ],
];   