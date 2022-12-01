<?php

use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;

return [
    [
        'class' => SerialColumn::class
    ],
    'namaBarang',
    [
        'class' => DataColumn::class,
        'attribute' => 'qtyMasuk',
        'contentOptions' => [
            'class' => 'text-end'
        ]
    ],
    [
        'class' => DataColumn::class,
        'attribute' => 'qtyKeluar',
        'contentOptions' => [
            'class' => 'text-end'
        ]
    ],
    [
        'class' => DataColumn::class,
        'attribute' => 'stock',
        'contentOptions' => [
            'class' => 'text-end'
        ]
    ],

];