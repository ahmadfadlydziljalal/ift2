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

<div class="card bg-transparent">
    <div class="card-body d-flex flex-column gap-3">

        <div class="d-flex flex-column gap-3">
            <div class="d-flex flex-row gap-2">
               <?php if (!$model->proformaDebitNote) : ?>

                  <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-proforma-debit-note', 'id' => $model->id], [
                     'class' => 'btn btn-success'
                  ]) ?>

               <?php else : ?>

                  <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-proforma-debit-note', 'id' => $model->id], [
                     'class' => 'btn btn-success',
                     'target' => '_blank',
                     'rel' => 'noopener noreferrer'
                  ]) ?>

                  <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-proforma-debit-note', 'id' => $model->id], [
                     'class' => 'btn btn-primary'
                  ]) ?>

                  <?php /* @see app\controllers\QuotationController::actionDeleteProformaDebitNote() */ ?>
                  <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-proforma-debit-note', 'id' => $model->id], [
                     'class' => 'btn btn-danger',
                     'data-method' => 'post',
                     'data-confirm' => 'Apakah Anda akan menghapus detail proforma debit note ini ?'
                  ]) ?>

               <?php endif; ?>
            </div>
        </div>

       <?php if ($model->proformaDebitNote) : ?>
           <div>
              <?= DetailView::widget([
                 'model' => $model->proformaDebitNote,
                 'attributes' => [
                    'nomor',
                    'tanggal:date',
                    [
                       'attribute' => 'pph_23_percent',
                       'value' => $model->proformaDebitNote->getPph23Label()
                    ]
                 ]
              ]) ?>
           </div>

           <div class="d-flex flex-column">
              <?= $this->render('_view_proforma_debit_note_detail_barang', ['model' => $model]) ?>
              <?= $this->render('_view_proforma_debit_note_detail_service', ['model' => $model]) ?>
           </div>

       <?php endif ?>
    </div>
</div>