<?php

use app\models\ClaimPettyCash;
use yii\bootstrap5\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
    ],
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'width' => '50px',
        'detailUrl' => Url::toRoute(['claim-petty-cash/expand-item']),
        'expandOneOnly' => true,
        'header' => '',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'nomor',
        'format' => 'text',
        'value' => function ($model) {
            /** @var ClaimPettyCash $model */
            return $model->nomorDisplay;
        }
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'vendor_id',
        'format' => 'text',
        'value' => 'vendor.nama'
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'tanggal',
        'format' => 'date',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'remarks',
        'format' => 'nText',
        'contentOptions' => [
            'class' => 'text-wrap'
        ]
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'approved_by_id',
        'value' => 'approvedBy.nama',
        'format' => 'text',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'attribute' => 'acknowledge_by_id',
        'value' => 'acknowledgeBy.nama',
        'format' => 'text',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'label' => 'Total',
        'format' => 'raw',
        'value' => function ($model) {
            /** @var ClaimPettyCash $model */
            return
                Html::beginTag('div', ['class' => 'd-flex justify-content-between gap-1']) .
                Html::tag('span', Yii::$app->formatter->currencyCode) .
                Html::tag('span', Yii::$app->formatter->asDecimal($model->totalClaim, 2)) .
                Html::endTag('div');
        },
        'contentOptions' => [
            'class' => 'text-end',

        ]
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'urlCreator' => function ($action, $model) {
            return Url::to([
                $action,
                'id' => $model->id
            ]);
        },
        'template' => '{print} {update} {view} {delete}',
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