<?php

use app\models\Card;
use kartik\grid\DataColumn;
use kartik\grid\GridView;

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
        'attribute' => 'nomor',
        'format' => 'text',
    ],
    [
        'class' => DataColumn::class,
        'attribute' => 'vendor_id',
        'format' => 'text',
        'value' => 'vendor.nama',
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => Card::find()->map(Card::GET_ONLY_VENDOR),
        'filterWidgetOptions' => [
            'options' => [
                'prompt' => '= Pilih salah satu ='
            ]
        ]
    ],

    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'tanggal',
        'format' => 'date',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'material_requisition_id',
        'format' => 'text',
        'value' => 'materialRequisition.nomor'
    ],
    /*[
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'reference_number',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'remarks',
        'format' => 'ntext',
    ],*/
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'approved_by',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'acknowledge_by',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'created_at',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // 'format'=>'text',
    // ],

    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'updated_by',
    // 'format'=>'text',
    // ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   