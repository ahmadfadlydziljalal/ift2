<?php


/* @var $this View */
/* @see \app\controllers\QuotationController::actionCreateDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionUpdateDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionDeleteDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionPrintDeliveryReceipt() */

/* @var $model Quotation|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

?>

<div class="card rounded shadow border-0" id="delivery-receipt">
    <div class="card-header">Delivery Receipt</div>
    <div class="card-body">
        <div class="d-flex flex-row gap-2">

           <?php if (!$model->quotationDeliveryReceipt) : ?>

              <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-delivery-receipt', 'id' => $model->id], [
                 'class' => 'btn btn-success'
              ]) ?>

           <?php else : ?>

              <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-delivery-receipt', 'id' => $model->id], [
                 'class' => 'btn btn-success',
                 'target' => '_blank',
                 'rel' => 'noopener noreferrer'
              ]) ?>

              <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-delivery-receipt', 'id' => $model->id], [
                 'class' => 'btn btn-primary'
              ]) ?>

              <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-delivery-receipt', 'id' => $model->id], [
                 'class' => 'btn btn-danger',
                 'data-method' => 'post',
                 'data-confirm' => 'Apakah Anda akan menghapus delivery receipt ini ?'
              ]) ?>

           <?php endif; ?>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
           <?php

           if ($model->quotationDeliveryReceipt) {
              echo DetailView::widget([
                 'model' => $model->quotationDeliveryReceipt,
                 'attributes' => [
                    'nomor',
                    'tanggal:date',
                    'purchase_order_number',
                    'checker',
                    'vehicle',
                    'remarks:nText'
                 ]
              ]);
           } else {
              echo Html::tag('p', 'Belum ada form job', [
                 'class' => 'text-danger font-weight-bold'
              ]);
           }
           ?>
        </div>
    </div>
</div>