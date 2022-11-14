<?php

use app\models\TandaTerimaBarang;
use yii\bootstrap5\Html;
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
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'detailUrl' => Url::toRoute(['tanda-terima-barang/expand-item']),
        'expandOneOnly' => false,
        'header' => '',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'nomor',
        'format' => 'text',
        'value' => function ($model) {
            /** @var TandaTerimaBarang $model */
            return $model->getNomorDisplay();
        }
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'tanggal',
        'format' => 'date',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'nomorPurchaseOrder',
        'header' => 'Purchase Order',
        'format' => 'raw',
        'value' => function ($model) {
            /** @var TandaTerimaBarang $model */
            return empty($model->purchaseOrder) ? ''
                : $model->purchaseOrder->nomor;
        }
    ],
    [
        'header' => 'Status P.O',
        'format' => 'raw',
        'value' => function ($model) {
            /** @var TandaTerimaBarang $model */
            return $model->getStatusPesananYangSudahDiterimaInHtmlFormat();
        }
    ],

    /* [
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
     ],*/
//    [
//        'attribute' => 'nomorPurchaseOrder',
//        'header' => 'Nomor P.O',
//        'format' => 'raw',
//        'value' => function ($model) {
//            /** @var TandaTerimaBarang $model */
//            return !empty($model->purchaseOrder) ? $model->purchaseOrder->getNomorDisplay() : '';
//        }
//    ],
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