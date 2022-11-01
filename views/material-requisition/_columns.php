<?php

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
        'attribute' => 'nomor',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'vendor_id',
        'format' => 'text',
        'value' => 'vendor.nama'
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'tanggal',
        'format' => 'date',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'remarks',
        'format' => 'nText',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'approved_by',
        'format' => 'text',
    ],
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
    // 'attribute'=>'created_by',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'updated_by',
    // 'format'=>'text',
    // ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{print} {update} {view} {delete}',
        'buttons' => [
            'print' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer-fill"></i>', ['print', 'id' => $model->id], [
                    'class' => 'print text-success',
                    'target' => '_blank',
                    'rel' => 'noopener noreferrer'
                ]);
            },
        ],
    ],
];   