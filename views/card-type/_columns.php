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
        'attribute'=>'nama',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'kode',
        'format'=>'text',
    ],
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
    ],
];   