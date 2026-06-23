<?php

/* @var $this View */

/* @var $model QuotationDeliveryReceipt|string|ActiveRecord */

use app\models\QuotationDeliveryReceipt;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;

?>

<div class="d-flex flex-column gap-2">
    <div class="row rows-col-sm-12 rows-col-md-2 row-cols-lg-4">
        <div class="col">
            <div class="d-inline-flex flex-column gap-2">
                <div><i class="bi bi-calendar"></i> Tanggal</div>
                <span><?= Yii::$app->formatter->asDate($model->tanggal) ?></span>
            </div>
        </div>
        <div class="col">
            <div class="d-inline-flex flex-column gap-2">
                <div class="fw-bold"><i class="bi bi-basket3"></i> P.O Number</div>
                <span><?= $model->purchase_order_number ?: 'Not available' ?></span>
            </div>
        </div>
        <div class="col">
            <div class="d-inline-flex flex-column gap-2">
                <div class="fw-bold"><i class="bi bi-check-circle"></i> Checker</div>
                <span><?= $model->checker ?></span>
            </div>
        </div>

        <div class="col">
            <div class="d-inline-flex flex-column gap-2">
                <div class="fw-bold"><i class="bi bi-truck"></i> Vehicle</div>
                <span><?= empty($model->vehicle) ? 'Not Available' : $model->vehicle ?></span>
            </div>
        </div>
    </div>

    <div class="d-inline-flex flex-column gap-2 mt-3">
        <div class="fw-bold"><i class="bi bi-hand-thumbs-up"></i> Remarks</div>
        <span><?= empty($model->remarks) ? "No Remarks" : nl2br($model->remarks) ?></span>
    </div>

    <div class="my-2"></div>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query'      => $model->getQuotationDeliveryReceiptDetails(),
            'pagination' => false,
            'sort'       => false
        ]),
        'layout'       => '{items}',
        'columns'      => [
            [
                'class' => SerialColumn::class
            ],
            'id',
            [
                'class'  => DataColumn::class,
                'header' => 'Barang',
                'value'  => 'quotationBarang.barang.nama'
            ],
            [
                'class'  => DataColumn::class,
                'value'  => 'quotationBarang.quantity',
                'header' => 'Quotation Qty'
            ],
            [
                'class'     => DataColumn::class,
                'attribute' => 'quantity',
                'value'     => 'quantity',
                'header'    => 'Qty Dikirim'
            ],
        ]
    ]) ?>
</div>

