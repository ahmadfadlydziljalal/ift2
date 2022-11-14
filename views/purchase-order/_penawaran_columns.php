<?php

use app\models\MaterialRequisitionDetailPenawaran;
use kartik\grid\DataColumn;
use kartik\grid\SerialColumn;

return [
    [
        'class' => SerialColumn::class
    ],
    [
        'class' => DataColumn::class,
        'header' => 'Vendor',
        'value' => function ($model) {
            /** @var MaterialRequisitionDetailPenawaran $model */
            return $model->vendor->nama;
        }
    ],
    [
        'class' => DataColumn::class,
        'header' => 'Material Requisition',
        'value' => function ($model) {
            /** @var MaterialRequisitionDetailPenawaran $model */
            return $model->materialRequisitionDetail->materialRequisition->nomor;
        }
    ],
    [
        'class' => DataColumn::class,
        'header' => 'Tipe Pembelian',
        'value' => function ($model) {
            /** @var MaterialRequisitionDetailPenawaran $model */
            return $model->materialRequisitionDetail->barang->tipePembelian->nama;
        }
    ],
    [
        'class' => DataColumn::class,
        'header' => 'Barang',
        'value' => function ($model) {
            /** @var MaterialRequisitionDetailPenawaran $model */
            return $model->materialRequisitionDetail->barang->nama;
        }
    ],
    [
        'class' => DataColumn::class,
        'header' => 'Part Number',
        'value' => function ($model) {
            /** @var MaterialRequisitionDetailPenawaran $model */
            return $model->materialRequisitionDetail->barang->part_number;
        }
    ],
    [
        'class' => DataColumn::class,
        'header' => 'IFT Number',
        'value' => function ($model) {
            /** @var MaterialRequisitionDetailPenawaran $model */
            return $model->materialRequisitionDetail->barang->ift_number;
        }
    ],
    [
        'class' => DataColumn::class,
        'header' => 'Merk',
        'value' => function ($model) {
            /** @var MaterialRequisitionDetailPenawaran $model */
            return $model->materialRequisitionDetail->barang->merk_part_number;
        }
    ],
    [
        'class' => DataColumn::class,
        'header' => 'Description',
        'value' => function ($model) {
            /** @var MaterialRequisitionDetailPenawaran $model */
            return $model->materialRequisitionDetail->description;
        }
    ],
    [
        'class' => DataColumn::class,
        'header' => 'Qty',
        'contentOptions' => [
            'class' => 'text-end'
        ],
        'value' => function ($model) {
            /** @var MaterialRequisitionDetailPenawaran $model */
            return $model->materialRequisitionDetail->quantity;
        }
    ],
    [
        'class' => DataColumn::class,
        'header' => 'Satuan',
        'value' => function ($model) {
            /** @var MaterialRequisitionDetailPenawaran $model */
            return $model->materialRequisitionDetail->satuan->nama;
        }
    ],
    [
        'class' => DataColumn::class,
        'attribute' => 'mata_uang_id',
        'contentOptions' => [
            'class' => 'text-end'
        ],
        'value' => 'mataUang.singkatan'
    ],
    [
        'class' => DataColumn::class,
        'attribute' => 'harga_penawaran',
        'format' => ['decimal', 2],
        'contentOptions' => [
            'class' => 'text-end'
        ]
    ]

];