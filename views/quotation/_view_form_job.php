<?php

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Quotation|string|ActiveRecord */
/* @see \app\controllers\QuotationController::actionCreateFormJob() */
/* @see \app\controllers\QuotationController::actionUpdateFormJob() */
/* @see \app\controllers\QuotationController::actionDeleteFormJob() */
/* @see \app\controllers\QuotationController::actionDeleteFormJobType */
/* @see \app\controllers\QuotationController::actionDeleteFormJobServicePartType */
?>


<div id="form-job">
    <div class="d-flex flex-column gap-3">
        <div class="d-flex flex-row gap-2">
            <h3>Form Job</h3>
            <div class="ms-auto">
                <?php if (!$model->quotationFormJob) : ?>

                    <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-form-job', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success'
                    ]) ?>

                <?php else : ?>

                    <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-form-job', 'id' => $model->id], [
                        'class'  => 'btn btn-outline-success',
                        'target' => '_blank',
                        'rel'    => 'noopener noreferrer'
                    ]) ?>

                    <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-form-job', 'id' => $model->id], [
                        'class' => 'btn btn-outline-primary'
                    ]) ?>

                    <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-form-job', 'id' => $model->id], [
                        'class'        => 'btn btn-outline-danger',
                        'data-method'  => 'post',
                        'data-confirm' => 'Apakah Anda akan menghapus detail quotation barang ini ?'
                    ]) ?>

                <?php endif; ?>
            </div>
        </div>

        <?= $this->render('_view_form_job_table', [
            'model' => $model
        ]) ?>

    </div>
</div>