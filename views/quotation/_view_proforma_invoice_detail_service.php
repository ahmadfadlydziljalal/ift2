<?php


/* @var $this View */

/* @var $model Quotation|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\ProformaInvoiceDetailService;
use app\models\Quotation;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;

?>

<div class="d-flex flex-column">

    <div class="d-flex flex-column gap-3">
        <div class="d-flex flex-row gap-2">
            <h3>Service</h3>
            <div class="ms-auto">
                <?php if (!$model->proformaInvoice->proformaInvoiceDetailServices) : ?>

                    <?= Html::a('<div class="d-flex flex-nowrap gap-1"><i class="bi bi-plus-circle"></i> Tambah Service</div>', ['quotation/create-proforma-invoice-detail-service', 'id' => $model->proformaInvoice->id], [
                        'class' => 'btn btn-outline-success'
                    ]) ?>

                <?php else : ?>

                    <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-proforma-invoice-detail-service', 'id' => $model->proformaInvoice->id], [
                        'class' => 'btn btn-outline-primary'
                    ]) ?>

                    <?php /* @see \app\controllers\QuotationController::actionDeleteProformaInvoiceDetailService() */ ?>
                    <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-proforma-invoice-detail-service', 'id' => $model->proformaInvoice->id], [
                        'class'        => 'btn btn-outline-danger',
                        'data-method'  => 'post',
                        'data-confirm' => 'Apakah Anda akan menghapus detail proforma invoice ini ?'
                    ]) ?>

                <?php endif; ?>
            </div>
        </div>

        <?php if ($model->proformaInvoice->proformaInvoiceDetailServices) : ?>
            <div class="table-responsive">
                <?php try {
                    echo GridView::widget([
                        'dataProvider'     => new ActiveDataProvider([
                            'query'      => $model->proformaInvoice->getProformaInvoiceDetailServices(),
                            'pagination' => false,
                            'sort'       => false
                        ]),
                        'showPageSummary'  => false,
                        'headerRowOptions' => [
                            'class' => 'text-wrap text-center align-middle'
                        ],
                        'layout'           => '{items}',
                        'columns'          => [
                            [
                                'class'         => SerialColumn::class,
                                'footer'        => '',
                                'footerOptions' => [
                                    'colspan' => 7
                                ]
                            ],
                            [
                                'attribute'     => 'job_description',
                                'footerOptions' => [
                                    'hidden' => true
                                ]
                            ],
                            [
                                'attribute'      => 'hours',
                                'contentOptions' => [
                                    'class' => 'text-end'
                                ],
                                'footerOptions'  => [
                                    'hidden' => true
                                ]
                            ],
                            [
                                'header' => '',
                                'value'  => 'proformaInvoice.quotation.mataUang.singkatan',

                                'footerOptions' => [
                                    'hidden' => true
                                ]
                            ],
                            [
                                'attribute'      => 'rate_per_hour',
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
                                    /** @var ProformaInvoiceDetailService $model */
                                    /** @see ProformaInvoiceDetailService::getNominalDiscount() */
                                    return $model->nominalDiscount;
                                },
                                'footerOptions'  => [
                                    'hidden' => true
                                ]
                            ],
                            [
                                'class'          => DataColumn::class,
                                'attribute'      => 'rate_per_hour_after_discount',
                                'contentOptions' => [
                                    'class' => 'text-end'
                                ],
                                'value'          => function ($model) {
                                    /** @var ProformaInvoiceDetailService $model */
                                    /** @see ProformaInvoiceDetailService::getRatePerHourAfterDiscount() */
                                    return $model->ratePerHourAfterDiscount;
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
                                    /** @var ProformaInvoiceDetailService $model */
                                    /** @see ProformaInvoiceDetailService::getAmount() $model */
                                    return $model->amount;
                                },
                                'format'         => ['decimal', 2],
                                'footer'         => Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceDetailServicesTotal, 2),
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
                                            'colspan' => 7,
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
                                        /* @see \app\models\ProformaInvoice::getProformaInvoiceDetailServicesDasarPengenaanPajak() */
                                        'content' => Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceDetailServicesDasarPengenaanPajak, 2),
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
                                        /* @var \app\models\ProformaInvoice::getProformaInvoiceDetailServicesTotalVatNominal() */
                                        'content' => Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceDetailServicesTotalVatNominal, 2),
                                        'options' => [
                                            'class' => 'text-end',
                                        ]
                                    ],
                                ],

                            ],
                        ]
                    ]);
                } catch (Throwable $e) {
                    echo $e->getTraceAsString();
                } ?>
            </div>

        <?php endif; ?>
    </div>

</div>