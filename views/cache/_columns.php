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
        'attribute' => 'expire',
        'format' => 'datetime'
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'data',
        'contentOptions' => [
            'class' => 'text-wrap'
        ],
        'format' => 'text',
    ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   