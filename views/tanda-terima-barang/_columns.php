<?php

use app\models\TandaTerimaBarang;
use yii\helpers\Url;

return [
    [
        'class' => 'yii\grid\SerialColumn',
    ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'id',
    // 'format'=>'text',
    // ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'nomor',
        'format' => 'text',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'tanggal',
        'format' => 'date',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'catatan',
        'format' => 'ntext',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'received_by',
        'format' => 'text',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'messenger',
        'format' => 'text',
    ],
    [
        'attribute' => 'nomorPurchaseOrder',
        'format' => 'raw',
        'value' => function ($model) {
            /** @var TandaTerimaBarang $model */
            return $model->purchaseOrder->nomor;
        }
    ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'acknowledge_by_id',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'created_at',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'updated_at',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'created_by',
    // 'format'=>'text',
    // ],
    // [
    // 'class'=>'yii\grid\DataColumn',
    // 'attribute'=>'updated_by',
    // 'format'=>'text',
    // ],
    [
        'class' => 'yii\grid\ActionColumn',
        'urlCreator' => function ($action, $model) {
            return Url::to([
                $action,
                'id' => $model->id
            ]);
        },
    ],

];   