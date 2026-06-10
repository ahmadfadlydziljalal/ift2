<?php

/* @var $this View */

use yii\web\View;

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
        'class'     => '\yii\grid\DataColumn',
        'attribute' => 'nomor',
        'format'    => 'text',
    ],
    [
        'class'     => '\yii\grid\DataColumn',
        'attribute' => 'tanggal',
        'format'    => 'date',
    ],
    [
        'class'     => '\yii\grid\DataColumn',
        'attribute' => 'pelaksana',
        'format'    => 'text',
    ],
    [
        'class'     => '\yii\grid\DataColumn',
        'attribute' => 'keterangan',
        'format'    => 'ntext',
    ],
    [
        'class'     => '\yii\grid\DataColumn',
        'attribute' => 'data_pendukung_lainnya',
        'format'    => 'ntext',
    ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   