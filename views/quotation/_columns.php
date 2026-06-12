<?php

/* @var $this yii\web\View */

use app\models\Quotation;
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
        'class'     => '\yii\grid\DataColumn',
        'attribute' => 'nomor',
        'value'     => function (Quotation $model) {
            $validity = $model->getValidityBasedOnDateLimit('html');
            return $model->nomor . ' <br/>' .
                Html::tag('div',
                    Html::tag('small', 'Validity: ' .
                        $validity['html'] . ' ' .
                        $validity['howManyDaysAreLeftText']
                    ) .
                    Html::tag('div', $model->getValidityPeriod()),
                    [
                        'class' => 'ps-2 text-muted flex-column',
                    ]
                );
        },
        'format'    => 'raw',
    ],
//    [
//        'class'     => '\yii\grid\DataColumn',
//        'attribute' => 'mata_uang_id',
//        'format'    => 'text',
//    ],

    [
        'class'     => '\yii\grid\DataColumn',
        'attribute' => 'customer_id',
//        'value'     => 'customer.nama',
        'value'     => function (Quotation $model) {
            return $model->customer->nama . '<br/>' . Html::tag('div',
                    Html::tag('small', 'Attendance:') .
                    Html::tag('div', $model->attendant_1, ['class' => 'ps-3']) .
                    (!empty($model->attendant_2) ? Html::tag('div', $model->attendant_2, ['class' => 'ps-3']) : '')
                    ,
                    [
                        'class' => 'ps-2 text-muted flex-column',
                    ]
                );

        },
        'format'    => 'raw',
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
        'class' => 'yii\grid\ActionColumn',
    ],
];   