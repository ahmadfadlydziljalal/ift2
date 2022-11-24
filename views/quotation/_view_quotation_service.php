<?php

use app\enums\TextLinkEnum;
use app\models\Quotation;
use app\models\QuotationService;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $model Quotation|string|ActiveRecord */

?>


<div class="card rounded shadow border-0" id="service">
    <div class="card-header">Service</div>

    <div class="card-body">
        <div class="d-flex flex-row gap-2">
            <?php if (!$model->quotationServices) : ?>
                <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-service-quotation', 'id' => $model->id], [
                    'class' => 'btn btn-success'
                ]) ?>

            <?php else : ?>
                <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-service-quotation', 'id' => $model->id], [
                    'class' => 'btn btn-primary'
                ]) ?>

                <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-service-quotation', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data-method' => 'post',
                    'data-confirm' => 'Apakah Anda akan menghapus detail quotation service ini ?'
                ]) ?>

            <?php endif; ?>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getQuotationServices(),
                    'pagination' => false,
                    'sort' => false
                ]),
                'layout' => '{items}',
                'headerRowOptions' => [
                    'class' => 'text-wrap text-center align-middle'
                ],
                'columns' => [
                    [
                        'class' => SerialColumn::class,
                        'footer' => '',
                        'footerOptions' => [
                            'colspan' => 7
                        ]
                    ],
                    [
                        'attribute' => 'job_description',
                        'footerOptions' => [
                            'hidden' => true
                        ]
                    ],
                    [
                        'attribute' => 'hours',
                        'contentOptions' => [
                            'class' => 'text-end'
                        ],
                        'footerOptions' => [
                            'hidden' => true
                        ]
                    ],
                    [
                        'header' => '',
                        'value' => function ($model) {
                            /** @var QuotationService $model */
                            return $model->quotation->mataUang->singkatan;
                        },
                        'footerOptions' => [
                            'hidden' => true
                        ]
                    ],
                    [
                        'attribute' => 'rate_per_hour',
                        'format' => ['decimal', 2],
                        'contentOptions' => [
                            'class' => 'text-end'
                        ],
                        'footerOptions' => [
                            'hidden' => true
                        ]
                    ],
                    [
                        'attribute' => 'discount',
                        'footerOptions' => [
                            'hidden' => true
                        ]
                    ],
                    [
                        'attribute' => 'discount_nominal',
                        'format' => ['decimal', 2],
                        'contentOptions' => [
                            'class' => 'text-end'
                        ],
                        'value' => function ($model) {
                            /** @var QuotationService $model */
                            /** @see QuotationService::getNominalDiscount() */
                            return $model->nominalDiscount;
                        },
                        'footerOptions' => [
                            'hidden' => true
                        ]
                    ],
                    [
                        'class' => DataColumn::class,
                        'attribute' => 'rate_per_hour_after_discount',
                        'contentOptions' => [
                            'class' => 'text-end'
                        ],
                        'value' => function ($model) {
                            /** @var QuotationService $model */
                            /** @see QuotationService::getRatePerHourAfterDiscount() */
                            return $model->ratePerHourAfterDiscount;
                        },
                        'format' => ['decimal', 2],
                        'footer' => 'Total'
                    ],
                    [
                        'class' => DataColumn::class,
                        'attribute' => 'amount',
                        'contentOptions' => [
                            'class' => 'text-end'
                        ],
                        'value' => function ($model) {
                            /** @var QuotationService $model */
                            /** @see QuotationService::getAmount() $model */
                            return $model->amount;
                        },
                        'format' => ['decimal', 2],
                        'footer' => Yii::$app->formatter->asDecimal($model->quotationServicesTotal, 2),
                        'footerOptions' => [
                            'class' => 'text-end'
                        ]
                    ],
                ],
                'showFooter' => true,
                'beforeFooter' => [
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
                                    'colspan' => 7,
                                    'rowspan' => 2,
                                    'style' => [
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
                        'options' => [
                            'class' => 'table-warning'
                        ]
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
                        'options' => [
                            'class' => 'table-warning'
                        ]
                    ],
                ]
            ]) ?>
        </div>
    </div>

</div>