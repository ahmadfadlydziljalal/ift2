<?php

/* @var $this View */


use kartik\grid\SerialColumn;
use yii\web\View;

return [
    [
        'class' => SerialColumn::class,
    ],
    'nomor',
    'tanggal:date',
    'customer',
    'catatan_quotation_barang',
    'catatan_quotation_service',
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'delivery_fee',
        'format' => ['decimal', 2],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'materai_fee',
        'format' => ['decimal', 2],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'sum_barang_before_discount',
        'format' => ['decimal', 2],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'persentase_ppn_barang',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'ppn_barang',
        'format' => ['decimal', 2],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'total_price_barang',
        'format' => ['decimal', 2],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'sum_service_before_discount',
        'format' => ['decimal', 2],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'dpp_service',
        'format' => ['decimal', 2],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'persentase_ppn_service',
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'ppn_service',
        'format' => ['decimal', 2],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'total_price_service',
        'format' => ['decimal', 2],
    ],
    [
        'class' => 'kartik\grid\DataColumn',
        'hAlign' => 'right',
        'attribute' => 'grand_total',
        'format' => ['decimal', 2],
    ],


];