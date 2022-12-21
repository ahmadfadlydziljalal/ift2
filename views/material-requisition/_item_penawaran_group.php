<?php

/* @var $key string */

/* @var $model array */

use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\grid\SerialColumn;

?>


<div class="material-requisition-item-group">

   <?php
   try {
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
                     'content' => $key,
                     'options' => [
                        'colspan' => 3,
                        'class' => 'border-0',
                        'style' => [
                           'text-align' => 'left !important'
                        ]
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
               'attribute' => 'description',
               'format' => 'raw',
               'contentOptions' => [
                  'style' => [
                     'padding' => '1em 0 1em 1em'
                  ]
               ],
               'value' => function ($model) {
                  /** @var MaterialRequisitionDetail $model */
                  return
                     GridView::widget([
                        'tableOptions' => [
                           'class' => 'table table-grid-view',

                        ],
                        'dataProvider' => new ActiveDataProvider([
                           'query' => $model->getMaterialRequisitionDetailPenawarans(),
                           'sort' => false,
                           'pagination' => false,
                        ]),
                        'layout' => '{items}',
                        'beforeHeader' => [
                           [
                              'columns' => [
                                 [
                                    'content' => $model->quantity . ' ' . $model->satuanNama . ': ' .
                                       $model->barang->nama . '; ' .
                                       (empty($model->barang->part_number) ? 'Unknown part number' : $model->barang->part_number) . ' - ' .
                                       (empty($model->barang->merk_part_number) ? 'Unknown merk' : $model->barang->merk_part_number) . ' - ' .
                                       '(' . $model->barangIftNumber . ')',
                                    'options' => [
                                       'colspan' => 7,
                                       'class' => 'border-0',
                                       'style' => [
                                          'text-align' => 'left !important'
                                       ]
                                    ],
                                 ],
                              ],
                           ],
                        ],
                        'columns' => [
                           [
                              'class' => SerialColumn::class
                           ],
                           [
                              'class' => DataColumn::class,
                              'attribute' => 'vendor_id',
                              'value' => 'vendor.nama'
                           ],
                           [
                              'class' => DataColumn::class,
                              'attribute' => 'mata_uang_id',
                              'label' => '',
                              'header' => '',
                              'value' => 'mataUang.singkatan'
                           ],
                           [
                              'class' => DataColumn::class,
                              'attribute' => 'harga_penawaran',
                              'format' => ['decimal', 2],
                              'contentOptions' => [
                                 'class' => 'text-end'
                              ]
                           ],
                           [
                              'header' => 'Qty',
                              'contentOptions' => [
                                 'class' => 'text-end'
                              ],
                              'headerOptions' => [
                                 'class' => 'text-end'
                              ],
                              'value' => function ($model) {
                                 /** @var MaterialRequisitionDetailPenawaran $model */
                                 return $model->quantity_pesan;
                              }
                           ],
                           [
                              'header' => 'Harga Per Item',
                              'contentOptions' => [
                                 'class' => 'text-end'
                              ],
                              'headerOptions' => [
                                 'class' => 'text-end'
                              ],
                              'format' => ['decimal', 2],
                              'value' => function ($model) {
                                 /** @var MaterialRequisitionDetailPenawaran $model */
                                 return
                                    $model->materialRequisitionDetail->quantity * $model->harga_penawaran;
                              }
                           ],
                           [
                              'attribute' => 'statusLabel',
                              'header' => 'Status',
                              'format' => 'raw'
                           ],
                        ]
                     ]);
               }
            ],
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


</div>