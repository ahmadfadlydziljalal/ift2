<?php

/* @var $this yii\web\View */

/* @var $model app\models\Quotation|string|yii\db\ActiveRecord */


use app\models\QuotationService;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>

<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider'     => new ActiveDataProvider([
            'query'      => $model->getQuotationServices(),
            'pagination' => false,
            'sort'       => false
        ]),
        'layout'           => '{items}',
        'headerRowOptions' => [
            'class' => 'text-wrap text-center align-middle'
        ],
        'columns'          => [
            [
                'class'         => SerialColumn::class,
                'footer'        => '',
                'footerOptions' => [
                    'colspan' => 8
                ]
            ],
            [
                'attribute'     => 'job_description',
                'footerOptions' => [
                    'hidden' => true
                ]
            ],
            [
                'attribute'      => 'quantity',
                'contentOptions' => [
                    'class' => 'text-end'
                ],
                'footerOptions'  => [
                    'hidden' => true
                ]
            ],
            [
                'attribute'     => 'satuan_id',
                'footerOptions' => [
                    'hidden' => true
                ],
                'value'         => 'satuan.nama'
            ],
            [
                'header'        => '',
                'value'         => function ($model) {
                    /** @var QuotationService $model */
                    return $model->quotation->mataUang->singkatan;
                },
                'footerOptions' => [
                    'hidden' => true
                ]
            ],
            [
                'attribute'      => 'rate',
                'format'         => ['decimal', 2],
                'contentOptions' => [
                    'class' => 'text-end'
                ],
                'footerOptions'  => [
                    'hidden' => true
                ]
            ],
            [
                'attribute'     => 'discount',
                'footerOptions' => [
                    'hidden' => true
                ]
            ],
            [
                'attribute'      => 'discount_nominal',
                'format'         => ['decimal', 2],
                'contentOptions' => [
                    'class' => 'text-end'
                ],
                'value'          => function ($model) {
                    /** @var QuotationService $model */
                    /** @see QuotationService::getNominalDiscount() */
                    return $model->nominalDiscount;
                },
                'footerOptions'  => [
                    'hidden' => true
                ]
            ],
            [
                'class'          => DataColumn::class,
                'attribute'      => 'rate_after_discount',
                'contentOptions' => [
                    'class' => 'text-end'
                ],
                'value'          => function ($model) {
                    /** @var QuotationService $model */
                    /** @see QuotationService::getRateAfterDiscount() */
                    return $model->rateAfterDiscount;
                },
                'format'         => ['decimal', 2],
                'footer'         => 'Total'
            ],
            [
                'class'          => DataColumn::class,
                'attribute'      => 'amount',
                'contentOptions' => [
                    'class' => 'text-end'
                ],
                'value'          => function ($model) {
                    /** @var QuotationService $model */
                    /** @see QuotationService::getAmount() $model */
                    return $model->amount;
                },
                'format'         => ['decimal', 2],
                'footer'         => Yii::$app->formatter->asDecimal($model->quotationServicesTotal, 2),
                'footerOptions'  => [
                    'class' => 'text-end'
                ]
            ],
        ],
        'showFooter'       => true,
        'beforeFooter'     => [
            [
                'columns' => [
                    [
                        'content' =>
                            Html::tag('p', "Note:", ['class' => 'fw-bold']) .
                            Html::tag('p',
                                isset($model->catatan_quotation_service) ?
                                    nl2br($model->catatan_quotation_service) : '',
                                ['class' => 'fw-normal']
                            )
                        ,
                        'options' => [
                            'colspan' => 8,
                            'rowspan' => 2,
                            'style'   => [
                                'vertical-align' => 'top'
                            ]
                        ]
                    ],
                    [
                        'content' => 'DPP',
                    ],
                    [
                        /* @var Quotation::getQuotationServicesDasarPengenaanPajak() */
                        'content' => Yii::$app->formatter->asDecimal($model->quotationServicesDasarPengenaanPajak, 2),
                        'options' => [
                            'class' => 'text-end',
                        ]
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'content' => 'PPN',
                    ],
                    [
                        /* @var Quotation::getQuotationServicesTotalVatNominal() */
                        'content' => Yii::$app->formatter->asDecimal($model->quotationServicesTotalVatNominal, 2),
                        'options' => [
                            'class' => 'text-end',
                        ]
                    ],
                ],

            ],
        ]
    ]) ?>
</div>
