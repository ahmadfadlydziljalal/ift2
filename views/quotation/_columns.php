<?php

/* @var $this yii\web\View */

use app\models\Card;
use app\models\Quotation;
use kartik\grid\ExpandRowColumn;
use kartik\grid\GridView;
use yii\helpers\Html;

$renderItemTotal = function ($sign, $nama, $singkatanMataUang, $nominal, $classOptions = ''): string {
    return Html::tag('div',
        Html::tag('span', '(' . $sign . ')' . ' ' . $nama) .
        Html::tag('div',
            Html::tag('span', $singkatanMataUang) . " " .
            Html::tag('span', Yii::$app->formatter->asDecimal($nominal, 2)),
            [
                'class' => 'd-flex justify-content-between',
                'style' => 'width: 160px;'
            ]
        ),
        [
            'class' => 'd-flex justify-content-between ' . $classOptions,
        ]
    );
};

return [
    [
        'class' => 'yii\grid\SerialColumn',
    ],
//     [
//     'class'=>'\yii\grid\DataColumn',
//     'attribute'=>'id',
//     'format'=>'text',
//     ],
    [
        'class'         => ExpandRowColumn::class,
        'detailUrl'     => ['expand'], /** @see \app\controllers\QuotationController::actionExpand() */
        'vAlign'        => 'top',
        'expandOneOnly' => true,
    ],
    [
        'class'     => '\yii\grid\DataColumn',
        'attribute' => 'nomor',
        'value'     => function (Quotation $model) {

            $createdAt = !empty($model->created_at) ?
                Html::tag('span', '<i class="bi bi-clock-history"></i>' . ' Created At: ' . Yii::$app->formatter->asDatetime($model->created_at)) : '';

            $validity = $model->getValidityBasedOnDateLimit('html');
            $validityString = Html::tag('div',
                Html::tag('span', '<i class="bi bi-clock-history"></i>' . ' Validity: ' . $validity['html']) .
                Html::tag('div',
                    Html::tag('span', $validity['howManyDaysAreLeftText']) .
                    Html::tag('span', $model->getValidityPeriod()), ['class' => 'ps-3 d-flex flex-column']
                )
                , [
                    'class' => 'd-flex flex-column'
                ]);


            $formJob = empty($model->quotationFormJob) ? '' :
                Html::tag('div',
                    Html::tag('div', '<div><i class="bi bi-wrench"></i> Form Job:</div>' .
                        Html::a('<i class="bi bi-printer"></i> Print', ['quotation/print-form-job', 'id' => $model->id], [
                            'class'  => 'btn btn-link',
                            'target' => '_blank',
                            'rel'    => 'noopener noreferrer'
                        ])
                        , ['class' => 'd-flex justify-content-between align-items-center']) .
                    Html::tag('div',
                        Html::tag('span', 'Nomor: ' . $model->quotationFormJob->nomor) .
                        Html::tag('span', 'Date: ' . (Yii::$app->formatter->asDate($model->quotationFormJob->tanggal))) .
                        Html::tag('span', 'SPK: ' . ($model->quotationFormJob->nomorSuratPerintahKerja ?: ''))

                        , [
                            'class' => 'ps-3 d-flex flex-column'
                        ]
                    )
                    , [
                        'class' => 'd-flex flex-column',
                    ]
                );

            $deliveryReceipt = '';
            if (!empty($model->quotationDeliveryReceipts)) {
                $mapDeliveryReceipt = array_map(function ($deliveryReceipt) use (&$model) {
                    return Html::tag('div',
                        Html::tag('span', $deliveryReceipt->nomor) .
                        Html::a('<i class="bi bi-printer"></i> Print', ['quotation/print-delivery-receipt', 'id' => $deliveryReceipt->id], [
                            'class'  => 'btn btn-link',
                            'target' => '_blank',
                            'rel'    => 'noopener noreferrer'
                        ])
                        , ['class' => 'd-flex justify-content-between align-items-center']);
                }, $model->quotationDeliveryReceipts);

                $deliveryReceipt = Html::tag('div',
                    Html::tag('span', '<i class="bi bi-truck"></i> Delivery Receipt:') .
                    Html::tag('span', implode($mapDeliveryReceipt), ['class' => 'ps-3']), [
                        'class' => 'd-flex flex-column text-warning fw-bold'
                    ]);
            }
            return
                Html::tag('div',
                    $model->nomor .
                    $createdAt .
                    $validityString .
                    $formJob .
                    $deliveryReceipt
                    , [
                        'class' => 'd-flex flex-column gap-3',
                    ]);


        },
        'format'    => 'raw',
    ],
    [
        'class'               => '\kartik\grid\DataColumn',
        'attribute'           => 'customer_id',
        'filterType'          => GridView::FILTER_SELECT2,
        'filterWidgetOptions' => [
            'data'          => Card::find()->map(),
            'options'       => [
                'placeholder' => '= Pilih Customer =',
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ]
        ],
        'value'               => function (Quotation $model) {
            $customerName = $model->customer->nama . '<br/>';
            $attendance = Html::tag('div',
                Html::tag('span', '<i class="bi bi-person-rolodex"></i> Attendance:') .
                Html::tag('div', $model->attendant_1, ['class' => 'ps-3']) .
                (!empty($model->attendant_2) ? Html::tag('div', $model->attendant_2, ['class' => 'ps-3']) : '')
                ,
                [
                    'class' => 'd-flex flex-column',
                ]
            );

            $unit = '';
            if ($model->quotationFormJob) {
                $unit = Html::tag('div',
                    Html::tag('span', '<i class="bi bi-folder-check"></i> Unit:') .
                    Html::tag('div',
                        'Nomor Unit: ' . $model->quotationFormJob?->cardOwnEquipment?->nomor_unit . '<br/>' .
                        'Merk/Type: ' . $model->quotationFormJob?->cardOwnEquipment?->merk . '/' . $model->quotationFormJob?->cardOwnEquipment?->nama . '<br/>' .
                        'H M: ' . $model->quotationFormJob?->hour_meter . '<br/>' .
                        'Production No: ' . $model->quotationFormJob?->cardOwnEquipment?->serial_number . '<br/>' .
                        'Mekanik: ' . (!empty($model->quotationFormJob?->namaMekaniks) ? implode(", ", $model->quotationFormJob->namaMekaniks) : '')
                        , [
                            'class' => 'ps-3'
                        ]
                    )
                    ,
                    [
                        'class' => 'd-flex flex-column',
                    ]
                );
            }

            return
                Html::tag('div',
                    $customerName . $attendance . $unit
                    , [
                        'class' => 'd-flex flex-column gap-3',
                    ]);

        },
        'format'              => 'raw',
        'contentOptions'      => [
            'class' => 'text-wrap'
        ]
    ],
    /* [
         'class'     => '\yii\grid\DataColumn',
         'attribute' => 'tanggal',
         'format'    => 'date',
     ],

     [
         'class'     => '\yii\grid\DataColumn',
         'attribute' => 'tanggal_batas_valid',
         'format'    => 'date',
     ],*/
    ['class'          => '\yii\grid\DataColumn',
     'attribute'      => 'grandTotal',
     'value'          => function (Quotation $model) use ($renderItemTotal) {
         return Html::tag(
             'div',
             $renderItemTotal('+', 'Barang', $model->mataUang->singkatan, $model->quotationBarangsTotal) .
             $renderItemTotal('+', 'Service', $model->mataUang->singkatan, $model->quotationServicesTotal) .
             $renderItemTotal('+', 'Delivery Fee', $model->mataUang->singkatan, (!empty($model->delivery_fee) ? $model->delivery_fee : 0)) .
             $renderItemTotal('+', 'Materai', $model->mataUang->singkatan, (!empty($model->materai_fee) ? $model->materai_fee : 0)) .
             $renderItemTotal('-', 'Total Discount', $model->mataUang->singkatan, $model->quotationDiscountTotal, 'text-info fw-bold') .
             $renderItemTotal('=', 'Grand Total', $model->mataUang->singkatan, $model->quotationGrandTotal, 'fw-bold'),
             [
                 'class' => 'd-flex flex-column',
             ]
         );
     },
     'format'         => 'raw',
     'contentOptions' => [
         'class' => 'text-wrap',
         'style' => 'min-width: 320px; max-width: 320px;'
     ]
    ],
//    [
//        'class'     => '\yii\grid\DataColumn',
//        'attribute' => 'attendant_1',
//        'format'    => 'text',
//    ],
// [
// 'class'=>'\yii\grid\DataColumn',
// 'attribute'=>'attendant_phone_1',
// 'format'=>'text',
// ],
// [
// 'class'=>'\yii\grid\DataColumn',
// 'attribute'=>'attendant_email_1',
// 'format'=>'email',
// ],
//    [
//        'class'     => '\yii\grid\DataColumn',
//        'attribute' => 'attendant_2',
//        'format'    => 'text',
//    ],
// [
// 'class'=>'\yii\grid\DataColumn',
// 'attribute'=>'attendant_phone_2',
// 'format'=>'text',
// ],
// [
// 'class'=>'\yii\grid\DataColumn',
// 'attribute'=>'attendant_email_2',
// 'format'=>'email',
// ],
// [
// 'class'=>'\yii\grid\DataColumn',
// 'attribute'=>'catatan',
// 'format'=>'ntext',
// ],
    [
        'class'    => 'yii\grid\ActionColumn',
        'template' => '{view}',
    ],
];   