<?php

use app\models\ClaimPettyCash;
use yii\bootstrap5\Html;
use yii\helpers\Url;

return [
    [
        'class' => 'yii\grid\SerialColumn',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'nomor',
        'format' => 'text',
        'value' => function ($model) {
            /** @var ClaimPettyCash $model */
            return $model->nomorDisplay;
        }
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'vendor_id',
        'format' => 'text',
        'value' => 'vendor.nama'
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'tanggal',
        'format' => 'date',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'remarks',
        'format' => 'nText',
        'contentOptions' => [
            'class' => 'text-wrap'
        ]
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'approved_by_id',
        'format' => 'text',
    ],
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => 'acknowledge_by_id',
        'format' => 'text',
    ],
    [
        'class' => 'yii\grid\DataColumn',
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