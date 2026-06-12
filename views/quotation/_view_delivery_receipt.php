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
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ListView;

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


        <div class="row">
            <div class="col-12 mb-3">
                <div class="table-responsive">
                    <?php
                    if ($model->quotationDeliveryReceipts) {
                        echo ListView::widget([
                            'dataProvider' => new ActiveDataProvider([
                                'query'      => $model->getQuotationDeliveryReceipts(),
                                'pagination' => false,
                                'sort'       => false
                            ]),
                            'itemView'     => '_item_quotation_deliver_receipt',
                            'layout'       => '{items}',
                            'options'      => [
                                'class' => 'd-flex flex-column gap-3'
                            ]
                        ]);
                    } else {
                        echo Html::tag('p', 'Belum ada delivery receipt', [
                            'class' => 'text-danger font-weight-bold'
                        ]);
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>


</div>