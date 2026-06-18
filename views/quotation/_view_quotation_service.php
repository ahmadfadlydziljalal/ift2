<?php

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $model Quotation|string|ActiveRecord */

?>


<div id="service">
    <div class="d-flex flex-column gap-3">
        <div class="d-flex flex-row gap-2">

            <h3>Service</h3>

            <div class="ms-auto">
                <?php if (!$model->quotationServices) : ?>
                    <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-service-quotation', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success'
                    ]) ?>

                <?php else : ?>
                    <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-service-quotation', 'id' => $model->id], [
                        'class' => 'btn btn-outline-primary'
                    ]) ?>

                    <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-service-quotation', 'id' => $model->id], [
                        'class'        => 'btn btn-outline-danger',
                        'data-method'  => 'post',
                        'data-confirm' => 'Apakah Anda akan menghapus detail quotation service ini ?'
                    ]) ?>

                <?php endif; ?>
            </div>

        </div>

        <?= $this->render('_view_quotation_service_table', [
            'model' => $model
        ]) ?>

    </div>
</div>