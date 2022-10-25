<?php

use app\components\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;
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
        'class'=>'\yii\grid\DataColumn',
        'attribute'=>'atas_nama',
        'format'=>'text',
    ],
    [
        'class' => '\yii\grid\DataColumn',
        'attribute' => 'rekeningDetails',
        'format' => 'raw',
        'value' => function ($model) {

            $items = (Json::decode($model->nomorNomorRekeningBank));


            $string = '';
            if($items){
                ArrayHelper::multisort($items,'atas_nama');
                $string .= GridView::widget([
                    'tableOptions' => [
                        'class' => 'table table-bordered p-0 m-0'
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
                        'bank',
                        [
                            'attribute' => 'nomor_rekening',
                            'headerOptions' => [
                                'class' => 'text-end'
                            ],
                            'contentOptions' => [
                                'class' => 'text-end'
                            ],
                        ],
                    ],
                ]);
            }
            return $string;

        }
    ],
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
    ],
];   