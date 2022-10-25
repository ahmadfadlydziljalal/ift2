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
        'attribute'=>'card_id',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'nama',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'telepon',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'email',
        'format'=>'email',
    ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   