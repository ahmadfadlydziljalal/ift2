<?php

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;


/* @var $this View */
/* @var $model Quotation|string|ActiveRecord */
?>

<div id="proformaInvoice">
    <div class="d-flex flex-column gap-3">
        <div class="d-flex flex-row gap-2">
            <h3>Proforma Invoice</h3>
            <div class="ms-auto">
                <?php if (!$model->proformaInvoice) : ?>

                    <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-proforma-invoice', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success'
                    ]) ?>

                <?php else : ?>

                    <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-proforma-invoice', 'id' => $model->id], [
                        'class'  => 'btn btn-outline-success',
                        'target' => '_blank',
                        'rel'    => 'noopener noreferrer'
                    ]) ?>

                    <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-proforma-invoice', 'id' => $model->id], [
                        'class' => 'btn btn-outline-primary'
                    ]) ?>

                    <?php /* @see app\controllers\QuotationController::actionDeleteProformaInvoice() */ ?>
                    <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-proforma-invoice', 'id' => $model->id], [
                        'class'        => 'btn btn-outline-danger',
                        'data-method'  => 'post',
                        'data-confirm' => 'Apakah Anda akan menghapus detail proforma invoice ini ?'
                    ]) ?>

                <?php endif; ?>
            </div>
        </div>

        <?php if ($model->proformaInvoice) : ?>

            <?= DetailView::widget([
                'model'      => $model->proformaInvoice,
                'attributes' => [
                    'nomor',
                    'tanggal:date',
                    [
                        'attribute' => 'pph_23_percent',
                        'value'     => $model->proformaInvoice->getPph23Label()
                    ]
                ]
            ]) ?>
        
            <?= $this->render('_view_proforma_invoice_detail_barang', ['model' => $model]) ?>
            <?= $this->render('_view_proforma_invoice_detail_service', ['model' => $model]) ?>

        <?php endif ?>
    </div>


</div>