<?php

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $model Quotation|string|ActiveRecord */
?>

<div id="proformaDebitNote">
    <div class="d-flex flex-column gap-3">
        <div class="d-flex flex-row gap-2">
            <h3>Proforma Debit Note</h3>
            <div class="ms-auto">
                <?php if (!$model->proformaDebitNote) : ?>

                    <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-proforma-debit-note', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success'
                    ]) ?>

                <?php else : ?>

                    <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-proforma-debit-note', 'id' => $model->id], [
                        'class'  => 'btn btn-outline-success',
                        'target' => '_blank',
                        'rel'    => 'noopener noreferrer'
                    ]) ?>

                    <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-proforma-debit-note', 'id' => $model->id], [
                        'class' => 'btn btn-outline-primary'
                    ]) ?>

                    <?php /* @see app\controllers\QuotationController::actionDeleteProformaDebitNote() */ ?>
                    <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-proforma-debit-note', 'id' => $model->id], [
                        'class'        => 'btn btn-outline-danger',
                        'data-method'  => 'post',
                        'data-confirm' => 'Apakah Anda akan menghapus detail proforma debit note ini ?'
                    ]) ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>