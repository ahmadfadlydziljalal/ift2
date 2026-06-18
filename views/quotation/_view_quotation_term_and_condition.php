<?php


/* @var $this View */
/* @see \app\controllers\QuotationController::actionCreateTermAndCondition() */
/* @see \app\controllers\QuotationController::actionUpdateTermAndCondition() */
/* @see \app\controllers\QuotationController::actionDeleteTermAndCondition() */

/* @var $model Quotation|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;

?>


<div id="term-and-condition">

    <div class="d-flex flex-column gap-3">
        <div class="d-flex flex-row gap-2">

            <h3>Term & Condition</h3>

            <div class="ms-auto">
                <?php if (!$model->quotationTermAndConditions) : ?>
                    <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-term-and-condition', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success'
                    ]) ?>

                <?php else : ?>
                    <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-term-and-condition', 'id' => $model->id], [
                        'class' => 'btn btn-outline-primary'
                    ]) ?>

                    <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-term-and-condition', 'id' => $model->id], [
                        'class'        => 'btn btn-outline-danger',
                        'data-method'  => 'post',
                        'data-confirm' => 'Apakah Anda akan menghapus detail term and condition ini ?'
                    ]) ?>

                <?php endif; ?>
            </div>
        </div>


        <?= $this->render('_view_quotation_term_and_condition_table', [
            'model' => $model
        ]) ?> ?>
    </div>

</div>