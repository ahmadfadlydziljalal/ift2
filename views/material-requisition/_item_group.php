<?php

/* @var $key string */

/* @var $model array */

use app\components\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\SerialColumn;
use yii\helpers\Html;

?>


<div class="material-requisition-item-group">

    <?php
    try {

        $columns = [
            [
                'class' => SerialColumn::class
            ],
            [
                'attribute' => 'barangPartNumber',
                'header' => 'Part Number'
            ],
            [
                'attribute' => 'barangIftNumber',
                'header' => 'IFT Number'
            ],
            [
                'attribute' => 'barangMerkPartNumber',
                'header' => 'Merk'
            ],
            [
                'attribute' => 'description',
            ],
            [
                'attribute' => 'quantity',
            ],
            [
                'attribute' => 'satuanNama',
                'header' => 'Satuan'
            ],
        ];

        if ($this->context->action->id != 'print') {
            $columns = ArrayHelper::merge($columns, [
                [
                    'attribute' => 'purchaseOrderNomor',
                    'header' => 'P.O',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return empty($model['purchaseOrderNomor'])
                            ? Html::tag('span', "Belum dibuatkan P.O", ['class' => 'badge bg-danger'])
                            : $model['purchaseOrderNomor'];
                    }
                ],
                [
                    'attribute' => 'vendorNama',
                    'header' => 'Vendor'
                ],
            ]);
        }

        $columns = ArrayHelper::merge($columns, [
            [
                'attribute' => 'last_price',
                'format' => ['decimal', 2],
                'contentOptions' => [
                    'class' => 'text-end'
                ]
            ]
        ]);


        echo GridView::widget([
            'tableOptions' => [
                'class' => 'table table-grid-view bg-white p-0 m-0'
            ],
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $model,
                'pagination' => false,
                'sort' => false
            ]),
            'layout' => '{items}',
            'beforeHeader' => [
                [
                    'columns' => [
                        [
                            'content' => 'Status: ' . $key,
                            'options' => [
                                'colspan' => 6,
                                'class' => 'text-start border-0'
                            ],
                        ],
                    ],
                ],
            ],
            'columns' => $columns
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>


</div>