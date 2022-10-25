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
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'expire',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'data',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'user_id',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'last_write',
        'format'=>'text',
    ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   