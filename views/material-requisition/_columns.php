<?php

use app\models\MaterialRequisition;
use yii\bootstrap5\Html;
use yii\helpers\Url;

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
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'detailUrl' => Url::toRoute(['material-requisition/expand-item']),
        'expandOneOnly' => true,
        'header' => '',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'nomor',
        'format' => 'text',
        'value' => function ($model) {
            /** @var MaterialRequisition $model */
            return $model->getNomorDisplay();
        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'vendor_id',
        'format' => 'text',
        'value' => 'vendor.nama'
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'tanggal',
        'format' => 'date',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'remarks',
        'format' => 'nText',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'approved_by',
        'format' => 'text',
    ],
    // [
    // 'class'=>'\yii\grid\DataColumn',
    // 'attribute'=>'acknowledge_by',
    // 'format'=>'text',
    // ],
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
        //'template' => '{print}{view}{update}{delete}{actions}',
//        'buttons' => [
//            'actions' => function ($url, $model, $key) {
//                return ButtonDropdown::widget([
//                    'encodeLabel' => false,
//                    'label' => 'Actions',
//                    'direction' => ButtonDropdown::DIRECTION_RIGHT,
//                    'dropdown' => [
//                        'encodeLabels' => false,
//                        'items' => [
//
//                            '<h6 class="dropdown-header">' . $model->nomor . '</h6>',
//                            '<div class="dropdown-divider"></div>',
//                            /*[
//                                'label' => 'Print As Pdf',
//                                'linkOptions' => [
//                                    'target' => '_blank',
//                                    'rel' => 'noopener noreferrer'
//                                ],
//                                'url' => ['print-pdf', 'id' => $model->id],
//                                'visible' => true,   // same as above
//                            ],*/
//                            [
//                                'label' => 'Print',
//                                'linkOptions' => [
//                                    'target' => '_blank',
//                                    'rel' => 'noopener noreferrer'
//                                ],
//                                'url' => ['print', 'id' => $model->id],
//                                'visible' => true,   // same as above
//                            ],
//                            '<div class="dropdown-divider"></div>',
//                            [
//                                'label' => Yii::t('yii', 'View'),
//                                'url' => ['view', 'id' => $model->id],
//                                'linkOptions' => [
//                                    'data' => [
//                                        'pjax' => '0',
//                                    ],
//                                ],
//                            ],
//                            [
//                                'label' => Yii::t('yii', 'Update'),
//                                'url' => ['update', 'id' => $model->id],
//                                'linkOptions' => [
//                                    'data' => [
//                                        'pjax' => '0',
//                                    ],
//                                ],
//                                'visible' => true,  // if you want to hide an item based on a condition, use this
//                            ],
//                            [
//                                'label' => Yii::t('yii', 'Delete'),
//                                'linkOptions' => [
//                                    'data' => [
//                                        'method' => 'post',
//                                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
//                                    ],
//                                ],
//                                'url' => ['delete', 'id' => $model->id],
//                                'visible' => true,   // same as above
//                            ],
//                        ],
//                        'options' => [
//                            'class' => 'dropdown-menu-right', // right dropdown
//                        ],
//                    ],
//                    'buttonOptions' => [
//                        'class' => 'btn-sm btn-outline-primary'
//                    ]
//                ]);
//            }
//        ],
        'template' => '{print} {view} {update} {delete}',
        'buttons' => [
            'print' => function ($url, $model) {
                return Html::a('<i class="bi bi-printer-fill"></i>', ['print', 'id' => $model->id], [
                    'class' => 'print text-success',
                    'target' => '_blank',
                    'rel' => 'noopener noreferrer'
                ]);
            },
        ],
    ],
];   