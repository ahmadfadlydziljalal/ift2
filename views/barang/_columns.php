<?php

use app\components\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\helpers\Json;

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
        'contentOptions' => [
            'class' => 'text-wrap'
        ]
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'part_number',
        'format' => 'raw',
        'value' => function($model){
            return
                Html::tag('span', $model->part_number) . '<br/>'
                . Html::tag('span', $model->keterangan)
                ;
        }
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'satuanHarga',
        'format' => 'raw',
        'value' => function ($model) {

            /** @var $model \app\models\Barang*/
            $items = (Json::decode($model->satuanHarga));
            $string = '';
            if($items){
                ArrayHelper::multisort($items,'vendor');
                $string .= GridView::widget([
                    'tableOptions' => [
                        'class' => 'table p-0 m-0'
                    ],
                    'dataProvider' => new ArrayDataProvider([
                        'allModels' => $items,
                        'pagination' => false
                    ]),
                    'layout' => '{items}',
                    'columns' => [
                        [
                            'class' => SerialColumn::class
                        ],
                        'vendor',
                        'satuan',
                        [
                            'attribute' => 'harga_beli',
                            'format' => ['decimal', 2],
                            'contentOptions' => [
                                'class' => 'text-end'
                            ]
                        ],
                        [
                            'attribute' => 'harga_jual',
                            'format' => ['decimal', 2],
                            'contentOptions' => [
                                'class' => 'text-end'
                            ]
                        ],
                    ],
                ]);
            }
            return $string;

        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
    ],
];   