<?php

use app\enums\TextLinkEnum;
use app\models\QuotationDeliveryReceipt;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model QuotationDeliveryReceipt */

?>

<div class="card bg-transparent">
    <div class="card-body border-bottom fw-bold">
        <div class="d-flex justify-content-between">

            <div>
                <i class="bi bi-file-pdf"></i> <?= $model->nomor ?>
            </div>

            <?= Html::a(
                TextLinkEnum::DELETE->value,
                ['quotation/delete-delivery-receipt', 'id' => $model->id],
                [
                    'data'  => [
                        'confirm' => 'Hapus delivery receipt ini ?',
                        'method'  => 'post'
                    ],
                    'class' => 'btn btn-danger'
                ]
            ) ?>

        </div>
    </div>
    <div class="card-body">
        <?= $this->render('_item_item_quotation_deliver_receipt', [
            'model' => $model
        ]) ?>
    </div>
    <div class="card-footer border-top p-3">
        <div class="d-flex justify-content-between flex-wrap gap-3">
            <div>
                <?= Html::a(
                    TextLinkEnum::UPDATE->value,
                    ['quotation/update-delivery-receipt', 'id' => $model->id],
                    [
                        'class' => 'btn btn-primary'
                    ]
                ) ?>
                <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-delivery-receipt', 'id' => $model->id], [
                    'class'  => 'btn btn-success',
                    'target' => '_blank',
                    'rel'    => 'noopener noreferrer'
                ]) ?>
            </div>
            <div>

                <?php if (!$model->tanggal_konfirmasi_diterima_customer) : ?>
                    <?= Html::a(
                        "Konfirmasi Terima Customer",
                        ['quotation/konfirmasi-diterima-customer', 'id' => $model->id],
                        [
                            'class' => 'btn btn-primary'
                        ]
                    ) ?>
                <?php else : ?>
                    <?= Html::tag('span', 'Terkonfirmasi; ' . Yii::$app->formatter->asDate($model->tanggal_konfirmasi_diterima_customer), [
                        'class' => 'badge bg-success'
                    ]) ?>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>