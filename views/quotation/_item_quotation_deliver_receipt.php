<?php

use app\enums\TextLinkEnum;
use app\models\QuotationDeliveryReceipt;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model QuotationDeliveryReceipt */

?>

<div class="card border-1 rounded shadow">
    <div class="card-body border-bottom fw-bold">
        <i class="bi bi-file-pdf"></i> <?= $model->nomor ?>
    </div>
    <div class="card-body">
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
             'query' => $model->getQuotationDeliveryReceiptDetails(),
             'pagination' => false,
             'sort' => false
          ]),
          'layout' => '{items}',
          'columns' => [
             [
                'class' => SerialColumn::class
             ],
             [
                'class' => DataColumn::class,
                'value' => 'quotationBarang.barang.nama'
             ]
          ]
       ]) ?>

    </div>

    <div class="card-footer border-top p-3">
        <div class="d-flex flex-row gap-3">
            <div>
               <?= Html::a(TextLinkEnum::UPDATE->value,
                  ['quotation/update-delivery-receipt', 'id' => $model->id],
                  [
                     'class' => 'btn btn-primary'
                  ]
               ) ?>
               <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-delivery-receipt', 'id' => $model->id], [
                  'class' => 'btn btn-success',
                  'target' => '_blank',
                  'rel' => 'noopener noreferrer'
               ]) ?>
            </div>
            <div class="ms-auto">
               <?= Html::a(TextLinkEnum::DELETE->value,
                  ['quotation/delete-delivery-receipt', 'id' => $model->id],
                  [
                     'data' => [
                        'confirm' => 'Hapus delivery receipt ini ?',
                        'method' => 'post'
                     ],
                     'class' => 'btn btn-danger'
                  ]) ?>
            </div>
        </div>
    </div>
</div>