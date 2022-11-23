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
        'attribute'=>'nomor',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'mata_uang_id',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'tanggal',
        'format'=>'date',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'customer_id',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'tanggal_batas_valid',
        'format'=>'date',
    ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'attendant_1',
        // 'format'=>'text',
    // ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'attendant_phone_1',
        // 'format'=>'text',
    // ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'attendant_email_1',
        // 'format'=>'email',
    // ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'attendant_2',
        // 'format'=>'text',
    // ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'attendant_phone_2',
        // 'format'=>'text',
    // ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'attendant_email_2',
        // 'format'=>'email',
    // ],
    // [
        // 'class'=>'\yii\grid\DataColumn',
        // 'attribute'=>'catatan',
        // 'format'=>'ntext',
    // ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   