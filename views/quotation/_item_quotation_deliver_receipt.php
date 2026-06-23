<?php

use app\enums\TextLinkEnum;
use app\models\QuotationDeliveryReceipt;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model QuotationDeliveryReceipt */

?>

<div class="card border shadow-lg">
    <div class="card-header border-bottom fw-bold">
        <div class="d-flex justify-content-between align-items-center">
            <div class="card-text">
                <i class="bi bi-file-pdf"></i> <?= $model->nomor ?>
            </div>
            <div>
                <?php if (!$model->tanggal_konfirmasi_diterima_customer) :
                    echo Html::a("Konfirmasi", ['quotation/konfirmasi-diterima-customer', 'id' => $model->id], [
                        'class' => 'btn btn-outline-primary',
                        'title' => 'Konfirmasi diterima customer'
                    ]);
                else :
                    echo Html::tag('span', 'Ter-konfirmasi; ' . Yii::$app->formatter->asDate($model->tanggal_konfirmasi_diterima_customer), [
                        'class' => 'badge bg-success'
                    ]);
                endif ?>
                <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-delivery-receipt', 'id' => $model->id], [
                    'class'  => 'btn btn-outline-success',
                    'target' => '_blank',
                    'rel'    => 'noopener noreferrer'
                ]) ?>
                <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-delivery-receipt', 'id' => $model->id], [
                    'class' => 'btn btn-outline-primary'
                ]) ?>
                <?= Html::a(TextLinkEnum::HAPUS->value, ['quotation/delete-delivery-receipt', 'id' => $model->id], [
                    'data'  => [
                        'confirm' => 'Hapus delivery receipt ini ?',
                        'method'  => 'post'
                    ],
                    'class' => 'btn btn-danger'
                ]) ?>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?= $this->render('_item_item_quotation_deliver_receipt', [
            'model' => $model
        ]) ?>
    </div>
</div>