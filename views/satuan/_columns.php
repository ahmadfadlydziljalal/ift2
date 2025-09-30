<?php

/* @var $this yii\web\View */

use app\enums\KategoriSatuanEnum;

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
        'attribute' => 'nama',
        'format' => 'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'kategori',
        'filter' => KategoriSatuanEnum::map(),
        'value' => function ($model) {
            return KategoriSatuanEnum::tryFrom($model->kategori)->name;
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   