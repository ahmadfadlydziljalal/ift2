<?php

/* @var $key string */

/* @var $model array */

use app\components\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Json;

?>


<div class="material-requisition-item-group">

    <?php
    try {

        $columns = [
            [
                'class' => SerialColumn::class
            ],
            /* [
                 'class' => 'kartik\grid\ExpandRowColumn',
                 'width' => '50px',
                 'detailUrl' => Url::toRoute(['material-requisition/expand-item-group']),

             ],*/
            [
                'attribute' => 'barangNama',
                'header' => 'Nama'
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

        if ($this->context->action->id == 'expand-item') {
            $columns = ArrayHelper::merge(
                $columns,
                [
                    [
                        'attribute' => 'penawaranDariVendor',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $json = Json::decode($model['penawaranDariVendor']);
                            return empty($json[0]['status']) ?
                                Html::tag('span', "Belum dibuatkan penawaran", ['class' => 'badge bg-danger'])
                                : GridView::widget([
                                    'dataProvider' => new ArrayDataProvider([
                                        'allModels' => Json::decode($model['penawaranDariVendor'])
                                    ]),
                                    'layout' => '{items}',
                                    'columns' => [
                                        'vendor',
                                        [
                                            'attribute' => 'harga_penawaran',
                                            'contentOptions' => [
                                                'class' => 'text-end'
                                            ]
                                        ],
                                        'status'
                                    ]
                                ]);
                        }
                    ],
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
                ]
            );
        }


        echo GridView::widget([
            'id' => 'gridview-detail',
            'tableOptions' => [
                'class' => 'table table-grid-view bg-white p-0 m-0'
            ],
            'dataProvider' => new ArrayDataProvider([
                'key' => 'id',
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
            'columns' => $columns,
            'rowOptions' => function ($model, $key, $index, $grid) {
                return [
                    'data-id' => $model->id,
                    'class' => 'text-nowrap'
                ];
            }
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
        echo $e->getTraceAsString();
    }
    ?>


</div>