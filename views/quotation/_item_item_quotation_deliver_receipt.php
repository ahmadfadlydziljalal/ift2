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

<div>
    <div class="row rows-col-sm-12 rows-col-md-2">
        <div class="col">
            <div class="d-flex flex-column gap-3">
                <div>
                    <i class="bi bi-calendar"></i> <?= Yii::$app->formatter->asDate($model->tanggal) ?>
                </div>
                <div>
                    <i class="bi bi-basket3"></i> <?= $model->purchase_order_number ?>
                </div>
            </div>

        </div>
        <div class="col">
            <div class="d-flex flex-column gap-3">
                <div>
                    <i class="bi bi-check-circle"></i> <?= $model->checker ?>
                </div>
                <div>
                    <i class="bi bi-truck"></i> <?= $model->vehicle ?>
                </div>
            </div>
        </div>
    </div>
    <p class="mt-3">
        <i class="bi bi-hand-thumbs-up-fill"></i>
        <?= empty($model->remarks) ? "" : nl2br($model->remarks) ?>
    </p>
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

