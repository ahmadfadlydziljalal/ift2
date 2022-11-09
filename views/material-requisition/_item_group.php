<?php

/* @var $key string */

/* @var $models array */

use app\models\MaterialRequisitionDetail;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\helpers\Json;

?>


<div class="material-requisition-item-group">
    <?php if ($this->context->action->id == 'expand-item') : ?>

        <div class="card">
            <div class="card-header border-bottom">
                <p class="card-title fw-bold"><span class="bi bi-list"></span> <?= $key ?></p>
            </div>
            <div class="card-body">
                <table class="table table-bordered bg-white">
                    <thead>
                    <tr class="table-success text-center">
                        <th class="text-end">No.</th>
                        <th>Barang</th>
                        <th>Part Number</th>
                        <th>IFT Number</th>
                        <th>Merk</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($models as $i => $model) : ?>
                        <?php /** @var MaterialRequisitionDetail $model */ ?>
                        <tr>
                            <td rowspan="2" class="text-end"><?= ($i + 1) ?></td>
                            <td><?= $model->barang->nama ?></td>
                            <td><?= $model->barang->part_number ?></td>
                            <td><?= $model->barang->ift_number ?></td>
                            <td><?= $model->barang->merk_part_number ?></td>
                            <td><?= $model->description ?></td>
                            <td><?= $model->quantity ?></td>
                            <td><?= $model->satuan->nama ?></td>
                        </tr>

                        <tr>
                            <td colspan="7">

                                <?php
                                $json = Json::decode($model['penawaranDariVendor']);
                                echo empty($json[0]['status']) ?
                                    Html::tag('span', "Belum dibuatkan penawaran", ['class' => 'badge bg-danger'])
                                    : GridView::widget([
                                        'dataProvider' => new ArrayDataProvider([
                                            'allModels' => $json
                                        ]),
                                        'layout' => '{items}',
                                        'headerRowOptions' => [
                                            'class' => 'table table-primary'
                                        ],
                                        'columns' => [
                                            [
                                                'class' => SerialColumn::class,
                                                'contentOptions' => [
                                                    'class' => 'text-end'
                                                ],
                                            ],
                                            'vendor',
                                            [
                                                'attribute' => 'harga_penawaran',
                                                'contentOptions' => [
                                                    'class' => 'text-end'
                                                ]
                                            ],
                                            [
                                                'attribute' => 'status',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    $options = Json::decode($model['status_options']);
                                                    return Html::tag($options['tag'], $model['status'], $options['options']);
                                                }
                                            ],
                                            [
                                                'attribute' => 'purchase_order_id',
                                                'header' => 'Purchase Order'
                                            ]
                                        ]
                                    ]);
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <?php else : ?>

        <?php
        try {


            echo GridView::widget([
                'id' => 'gridview-detail',
                'tableOptions' => [
                    'class' => 'table table-grid-view bg-white p-0 m-0'
                ],
                'dataProvider' => new ArrayDataProvider([
                    'key' => 'id',
                    'allModels' => $models,
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
                'columns' => [
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
                ],
                'headerRowOptions' => [
                    'class' => 'bg-primary text-light'
                ],
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

    <?php endif; ?>

</div>