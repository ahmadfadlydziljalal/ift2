<?php


/* @var $this View */
/* @see \app\controllers\QuotationController::actionCreateDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionUpdateDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionDeleteDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionDeleteAllDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionPrintDeliveryReceipt() */

/* @var $model Quotation|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ListView;

?>

<div class="card rounded shadow border-0" id="delivery-receipt">
    <div class="card-header">Delivery Receipt</div>
    <div class="card-body">
        <div class="d-flex flex-row gap-2">

           <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-delivery-receipt', 'id' => $model->id], [
              'class' => 'btn btn-success'
           ]) ?>

           <?= Html::a(TextLinkEnum::DELETE_ALL->value, ['quotation/delete-all-delivery-receipt', 'id' => $model->id], [
              'class' => 'btn btn-danger',
              'data-method' => 'post',
              'data-confirm' => 'Apakah Anda akan menghapus delivery receipt ini ?'
           ]) ?>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
           <?php

           if ($model->quotationDeliveryReceipts) {
              echo ListView::widget([
                 'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getQuotationDeliveryReceipts(),
                    'pagination' => false,
                    'sort' => false
                 ]),
                 'itemView' => '_item_quotation_deliver_receipt',
                 'layout' => '{items}',
                 'options' => [
                    'class' => 'd-flex flex-column gap-3'
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