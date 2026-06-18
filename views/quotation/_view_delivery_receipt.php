<?php


/* @var $this View */
/* @see \app\controllers\QuotationController::actionCreateDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionUpdateDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionDeleteDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionDeleteAllDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionPrintDeliveryReceipt() */

/* @var $model Quotation */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\helpers\Html;
use yii\web\View;

?>

<div id="delivery-receipt">

    <div class="d-flex flex-column gap-3">

        <div class="d-flex flex-row gap-2">
            <h3>Delivery Receipt</h3>
            <div class="ms-auto">
                <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-delivery-receipt', 'id' => $model->id], [
                    'class' => 'btn btn-outline-success'
                ]) ?>

                <?= Html::a(TextLinkEnum::DELETE_ALL->value, ['quotation/delete-all-delivery-receipt', 'id' => $model->id], [
                    'class'        => 'btn btn-outline-danger',
                    'data-method'  => 'post',
                    'data-confirm' => 'Apakah Anda akan menghapus delivery receipt ini ?'
                ]) ?>
            </div>
        </div>

        <?= $this->render('_view_delivery_receipt_table', [
            'model' => $model
        ]) ?>

    </div>


</div>