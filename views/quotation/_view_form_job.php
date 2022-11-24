<?php

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ListView;


/* @var $this View */
/* @var $model Quotation|string|ActiveRecord */
/* @see \app\controllers\QuotationController::actionCreateFormJob() */
/* @see \app\controllers\QuotationController::actionUpdateFormJob() */
/* @see \app\controllers\QuotationController::actionDeleteFormJob() */

?>
<div class="card rounded shadow border-0" id="form-job">
    <div class="card-header">Form Jobs</div>
    <div class="card-body">
        <div class="d-flex flex-row gap-2">

            <?php if (!$model->quotationFormJobs) : ?>

                <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-form-job', 'id' => $model->id], [
                    'class' => 'btn btn-success'
                ]) ?>

            <?php else : ?>

                <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-form-jobs', 'id' => $model->id], [
                    'class' => 'btn btn-success',
                    'target' => '_blank',
                    'rel' => 'noopener noreferrer'
                ]) ?>

                <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-form-job', 'id' => $model->id], [
                    'class' => 'btn btn-primary'
                ]) ?>

                <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-form-job', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data-method' => 'post',
                    'data-confirm' => 'Apakah Anda akan menghapus detail quotation barang ini ?'
                ]) ?>

            <?php endif; ?>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <?php try {
                echo ListView::widget([
                    'dataProvider' => new ActiveDataProvider([
                        'query' => $model->getQuotationFormJobs(),
                        'pagination' => false,
                        'sort' => false
                    ]),
                    'layout' => '{items}',
                    'itemView' => '_item_form_job',
                    'options' => [
                        'class' => 'd-flex flex-column gap-3'
                    ]
                ]);
            } catch (Throwable $e) {
                echo $e->getMessage();
            } ?>
        </div>
    </div>
</div>