<?php

/* @var $this yii\web\View */

use app\components\grid\ActionColumn;
use kartik\grid\DataColumn;
use kartik\grid\ExpandRowColumn;
use kartik\grid\SerialColumn;

return [
    [
        'class' => SerialColumn::class
    ],
    [
        'class'     => ExpandRowColumn::class,
        'detailUrl' => ['expand'],/** @see \app\controllers\StockController::actionExpand() */
    ],
    /* [
         'class'     => DataColumn::class,
         'attribute' => 'photo_thumbnail',
         'header'    => 'Photo',
         'format'    => 'raw',
         'value'     => function ($model) {
             if ($model['photo_thumbnail']) {
                 return Html::img($model['photo_thumbnail'], [
                     'alt'     => 'No image available',
                     'loading' => 'lazy',
                     'height'  => '32rem',
                     'width'   => 'auto',
                 ]);
             }
             return null;
         }
     ],*/
    'partNumber',
    [
        'class'     => DataColumn::class,
        'attribute' => 'kodeBarang',
        'header'    => 'Kode'
    ],
    [
        'class'          => DataColumn::class,
        'attribute'      => 'namaBarang',
        'contentOptions' => [
            'class' => 'text-nowrap'
        ]
    ],
    'merk',
    [
        'class'     => DataColumn::class,
        'attribute' => 'defaultSatuan',
        'header'    => 'UOM'
    ],
    [
        'class'          => DataColumn::class,
        'attribute'      => 'stockAwal',
        'contentOptions' => [
            'class' => 'text-end'
        ]
    ],
    [
        'class'          => DataColumn::class,
        'attribute'      => 'qtyMasuk',
        'contentOptions' => [
            'class' => 'text-end'
        ]
    ],
    [
        'class'          => DataColumn::class,
        'attribute'      => 'qtyKeluar',
        'contentOptions' => [
            'class' => 'text-end'
        ]
    ],
    [
        'class'          => DataColumn::class,
        'attribute'      => 'stockAkhir ',
        'contentOptions' => [
            'class' => 'text-end'
        ]
    ],
    [
        'class'       => ActionColumn::class,
        'mergeHeader' => false,
        'template'    => '{view}',
    ],
];