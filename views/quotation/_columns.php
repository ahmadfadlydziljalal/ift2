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
            $validity = $model->getValidityBasedOnDateLimit('html');
            $validityString = Html::tag('small', 'Validity: ' .
                $validity['html'] . ' ' .
                $validity['howManyDaysAreLeftText']
            );
            
            $formJob = empty($model->quotationFormJob) ? '' :
                Html::tag('div',
                    Html::tag('small', 'Form Job:') .
                    Html::tag('div',
                        'Nomor: ' . $model->quotationFormJob->nomor . '<br/>' .
                        'SPK: ' . ($model->quotationFormJob->nomorSuratPerintahKerja ?: '') . '<br/>' .
                        'Date: ' . (Yii::$app->formatter->asDate($model->quotationFormJob->tanggal) ?: '')
                        , [
                            'class' => 'ps-3'
                        ]
                    )
                    ,
                    [
                        'class' => 'ps-2 text-muted flex-column',
                    ]
                );

            return $model->nomor . ' <br/>' .
                $validityString . ' <br/>' .
                $model->getValidityPeriod() .
                $formJob;

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
                Html::tag('small', 'Attendance:') .
                Html::tag('div', $model->attendant_1, ['class' => 'ps-3']) .
                (!empty($model->attendant_2) ? Html::tag('div', $model->attendant_2, ['class' => 'ps-3']) : '')
                ,
                [
                    'class' => 'ps-2 text-muted flex-column',
                ]
            );

            $unit = '';
            if ($model->quotationFormJob) {
                $unit = Html::tag('div',
                    Html::tag('small', 'Unit:') .
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
                        'class' => 'ps-2 text-muted flex-column',
                    ]
                );
            }


            return $customerName . $attendance . $unit;

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