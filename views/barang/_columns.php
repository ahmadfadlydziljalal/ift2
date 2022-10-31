<?php

use app\models\Originalitas;
use app\models\TipePembelian;

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
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'detail' => function ($model, $key, $index, $column) {
            return $this->context->renderPartial('_item', ['model' => $model]);
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'expandOneOnly' => true
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'tipe_pembelian_id',
        'filter' => TipePembelian::find()->map(true),
        'value' => function ($model) {
            return $model->tipePembelianNama;
        },
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nama',
        'format' => 'text',
        'contentOptions' => [
            'class' => 'text-wrap'
        ]
    ],

    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'part_number'
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'merk_part_number',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'ift_number',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'originalitas_id',
        'filter' => Originalitas::find()->map(),
        'value' => function ($model) {
            return $model->originalitasNama;
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   