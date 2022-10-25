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
        'attribute'=>'lokasi',
        'format'=>'text',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'tanggal_produk',
        'format'=>'date',
    ],
    [
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'serial_number',
        'format'=>'text',
    ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   