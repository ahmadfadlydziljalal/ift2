<?php


/* @var $this View */

/* @var $model ClaimPettyCash */

use app\models\ClaimPettyCash;
use app\models\ClaimPettyCashNotaDetail;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\web\View;

?>

<div class="claim-petty-cash-item py-1">
    <?php
    try {
        echo GridView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => $model->getClaimPettyCashNotaDetails(),
                'pagination' => false,
                'sort' => false
            ]),
            'headerRowOptions' => [
                'class' => 'table table-primary'
            ],
            'layout' => '{items}',
            'columns' => [
                [
                    'class' => SerialColumn::class
                ],
                [
                    'header' => 'Vendor',
                    'value' => function ($model) {
                        /** @var ClaimPettyCashNotaDetail $model */
                        return $model->claimPettyCashNota->vendor->nama;
                    }
                ],
                [
                    'header' => 'Nota',
                    'value' => function ($model) {
                        /** @var ClaimPettyCashNotaDetail $model */
                        return $model->claimPettyCashNota->nomor;
                    }
                ],
                [
                    'header' => 'Tgl Nota',
                    'format' => 'date',
                    'value' => function ($model) {
                        /** @var ClaimPettyCashNotaDetail $model */
                        return $model->claimPettyCashNota->tanggal_nota;
                    }
                ],
                [
                    'header' => 'Tipe',
                    'value' => function ($model) {
                        /** @var ClaimPettyCashNotaDetail $model */
                        return isset($model->barang->tipePembelian)
                            ? $model->barang->tipePembelian->nama
                            : null;
                    }
                ],
                [
                    'attribute' => 'barang_id',
                    'value' => 'barang.nama'
                ],
                [
                    'attribute' => 'description',
                ],
                [
                    'attribute' => 'quantity',
                ],
                [
                    'attribute' => 'satuan_id',
                    'value' => 'satuan.nama'
                ],
                [
                    'attribute' => 'harga',
                    'format' => ['decimal', 2],
                    'contentOptions' => [
                        'class' => 'text-end'
                    ]
                ]
            ]
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>
</div>