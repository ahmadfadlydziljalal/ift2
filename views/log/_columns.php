<?php
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
        'attribute' => 'level',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'category',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'log_time',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'prefix',
        'format' => 'ntext',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'message',
        'format' => 'ntext',
        'contentOptions' => [
            'class' => 'text-nowrap'
        ]
    ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   