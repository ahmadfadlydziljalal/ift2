<?php

/* @var $this yii\web\View */


use app\enums\TipePembelianEnum;
use app\models\Barang;
use app\models\Originalitas;
use app\models\TipePembelian;
use kartik\date\DatePicker;
use kartik\grid\GridViewInterface;
use kartik\grid\SerialColumn;
use yii\bootstrap5\Html;

return [
    [
        'class'          => SerialColumn::class,
        'contentOptions' => [
            'class' => 'align-middle text-end'
        ],
    ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'id',
    // 'format'=>'text',
    // ],
    [
        'class'         => 'kartik\grid\ExpandRowColumn',
        'width'         => '50px',
        'detail'        => function ($model, $key, $index, $column) {
            return $this->context->renderPartial('_item', ['model' => $model]);
        },
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'expandOneOnly' => true
    ],
    [
        'class'     => '\yii\grid\DataColumn',
        'attribute' => 'tipe_pembelian_id',
        'header'    => 'Tipe',
        'filter'    => TipePembelian::find()->map([TipePembelianEnum::STOCK->value, TipePembelianEnum::PERLENGKAPAN->value]),
        'value'     => function ($model) {
            return $model->tipePembelianNama;
        },
    ],
    [
        'class'          => '\yii\grid\DataColumn',
        'attribute'      => 'nama',
        'format'         => 'text',
        'contentOptions' => [
            'class' => 'text-nowrap'
        ]
    ],

    [
        'class'          => '\yii\grid\DataColumn',
        'attribute'      => 'part_number',
        'contentOptions' => [
            'class' => 'font-monospace'
        ]
    ],
    [
        'class'     => '\yii\grid\DataColumn',
        'attribute' => 'merk_part_number',
        'label'     => 'Merk'
    ],
    [
        'class'          => '\yii\grid\DataColumn',
        'attribute'      => 'ift_number',
        'contentOptions' => [
            'class' => 'font-monospace'
        ],
    ],
    [
        'class'          => '\yii\grid\DataColumn',
        'attribute'      => 'originalitas_id',
        'filter'         => Originalitas::find()->map(),
        'value'          => function ($model) {
            return $model->originalitasNama;
        },
        'contentOptions' => [
            'class' => 'text-nowrap'
        ]
    ],
    [
        'class'               => '\kartik\grid\DataColumn',
        'filterType'          => GridViewInterface::FILTER_DATE,
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'autoclose' => true,
                'format'    => 'yyyy-mm-dd'
            ],
            'type'          => DatePicker::TYPE_INPUT,
        ],
        'attribute'           => 'initialize_start',
        'contentOptions'      => [
            'class' => 'text-end font-monospace'
        ],
        'format'              => 'date',
    ],
    [
        'class'          => '\yii\grid\DataColumn',
        'attribute'      => 'initialize_stock_quantity',
        'label'          => 'Initial Stock',
        'contentOptions' => [
            'class' => 'text-end font-monospace'
        ],
        'format'         => ['decimal', 2],
        'value'          => fn(Barang $model) => empty($model->initialize_stock_quantity) ? 0 : $model->initialize_stock_quantity,
    ],
    [
        'class'          => '\yii\grid\DataColumn',
        'attribute'      => 'photo',
        'format'         => 'raw',
        'contentOptions' => [
            'class' => 'text-center'
        ],
        'value'          => function ($model) {
            /** @var Barang $model */
            return $model->photoThumbnailAsTagImgHtmlElement;
        }
    ],
    [
        'class'           => 'kartik\grid\ActionColumn',
        'contentOptions'  => [
            'class' => 'text-nowrap'
        ],
        'template'        => '{header} {start} {divider} {view} {update} {delete}',
        'dropdown'        => true,
        'dropdownOptions' => [
            'class' => 'dropstart'
        ],
        'buttons'         => [
            'header'  => function ($url, $model, $key) {
                return Html::tag('h6', $model->nama, ['class' => 'dropdown-header']);
            },
            'divider' => function ($url, $model, $key) {
                return '<div class="dropdown-divider"></div>';
            },
            'start'   => function ($url, $model, $key) {
                return Html::a('<i class="bi bi-play-circle"></i> Start', ['start', 'id' => $model->id], [
                    'class'     => 'dropdown-item',
                    'data-pjax' => 0,
                    'title'     => 'Start',
                ]);
            }
        ],
        'viewOptions'     => [
            'label'       => '<i class="bi bi-eye-fill"></i> View',
            'title'       => 'View',
            'data-toggle' => 'tooltip'
        ],
        'updateOptions'   => [
            'label'       => '<i class="bi bi-pencil-fill"></i> Update',
            'title'       => 'Update',
            'data-toggle' => 'tooltip'
        ],
        'deleteOptions'   => [
            'label'        => '<i class="bi bi-trash"></i> Delete',
            'class'        => 'text-danger',
            'title'        => 'Delete',
            'data-pjax'    => 0,
            'data-confirm' => 'Are you sure you want to delete this item?',
            'data-method'  => 'post',
        ],
    ],
];   