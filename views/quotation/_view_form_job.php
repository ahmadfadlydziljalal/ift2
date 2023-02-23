<?php

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model Quotation|string|ActiveRecord */
/* @see \app\controllers\QuotationController::actionCreateFormJob() */
/* @see \app\controllers\QuotationController::actionUpdateFormJob() */
/* @see \app\controllers\QuotationController::actionDeleteFormJob() */

?>
<div class="card bg-transparent" id="form-job">

    <div class="card-body">
        <div class="d-flex flex-column gap-3">
            <div class="d-flex flex-row gap-2">

               <?php if (!$model->quotationFormJob) : ?>

                  <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-form-job', 'id' => $model->id], [
                     'class' => 'btn btn-success'
                  ]) ?>

               <?php else : ?>

                  <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-form-job', 'id' => $model->id], [
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

            <div class="table-responsive">
               <?php if ($model->quotationFormJob) {
                  echo DetailView::widget([
                     'model' => $model->quotationFormJob,
                     'attributes' => [
                        'nomor',
                        'tanggal',
                        [
                           'attribute' => 'card_own_equipment_id',
                           'value' => function ($model) {
                              return $model->cardOwnEquipmentLabel;
                           }
                        ],
                        'hour_meter',
                        'person_in_charge',
                        [
                           'attribute' => 'mekaniksId',
                           'format' => 'raw',
                           'value' => fn($model) => Html::ol($model->namaMekaniks, [
                              'item' => fn($item, $index) => Html::tag('li', $item)
                           ])
                        ],
                        'issue',
                        'remarks'
                     ]
                  ]);
               } else {
                  echo Html::tag('p', 'Belum ada form job', [
                     'class' => 'text-danger font-weight-bold'
                  ]);
               }
               ?>
            </div>
        </div>
    </div>

</div>