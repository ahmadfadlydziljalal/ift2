<?php

use yii\bootstrap5\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'yii\grid\SerialColumn',
    ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'id',
    // 'format'=>'text',
    // ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'nomor',
        'format' => 'text',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'vendor_id',
        'format' => 'text',
        'value' => 'vendor.nama'
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'tanggal',
        'format' => 'date',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'remarks',
        'format' => 'text',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'approved_by',
        'format' => 'text',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'acknowledge_by',
        'format' => 'text',
    ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'created_at',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'created_by',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'updated_by',
    // 'format'=>'text',
    // ],
    [
        'class' => 'yii\grid\ActionColumn',
        'urlCreator' => function ($action, $model) {
            return Url::to([
                $action,
                'id' => $model->id
            ]);
        },
        'template' => '{print} {update} {view} {delete}',
        'buttons' => [
            'print' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer-fill"></i>', ['print', 'id' => $model->id], [
                    'class' => 'print text-success',
                    'target' => '_blank',
                    'rel' => 'noopener noreferrer'
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