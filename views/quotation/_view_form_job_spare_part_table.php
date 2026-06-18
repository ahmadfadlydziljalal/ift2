<?php

/* @var $this yii\web\View */

/* @var $model app\models\Quotation|string|yii\db\ActiveRecord */

use kartik\grid\GridView;
use yii\data\ActiveDataProvider;

echo GridView::widget([
    'dataProvider' => new ActiveDataProvider([
        'query'      => $model->quotationFormJob->getQuotationFormJobSpareParts()
            ->joinWith(['satuan', 'barang'])
            ->orderBy(['id' => SORT_ASC]),
        'pagination' => false
    ]),
    'layout'       => "{items}",
    'responsive'   => true,
    'columns'      => [
        'barang.nama',
        [
            'attribute'      => 'quantity',
            'contentOptions' => [
                'class' => 'text-wrap text-end'
            ],
            'headerOptions'  => [
                'class' => 'text-nowrap text-end'
            ]
        ],
        [
            'attribute'      => 'satuan_id',
            'value'          => 'satuan.nama',
            'contentOptions' => [
                'class' => 'text-wrap'
            ]
        ]
    ],
    'showOnEmpty'  => false,
    'emptyText'    => false,
]);