<?php


/* @var $this View */
/* @var $model QuotationFormJob */

/* @var $quotation Quotation */

use app\models\Card;
use app\models\CardOwnEquipment;
use app\models\Quotation;
use app\models\QuotationFormJob;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;

?>


<div class="quotation-form">
   <?php $form = ActiveForm::begin() ?>

    <div class="card rounded border-0 shadow item">

        <div class="card-header d-flex justify-content-between">
           <?php if (!$model->isNewRecord) {
              echo Html::activeHiddenInput($model, "id");
           } ?>

           <?= Html::tag('span', 'Form Job', ['class' => 'fw-bold']) ?>
        </div>

        <div class="card-body">

            <div class="row row-cols-2 row-cols-lg-4">

                <!-- Tanggal -->
                <div class="col">
                   <?= $form->field($model, "tanggal")->widget(DatePicker::class); ?>
                </div>

                <!-- Person In Charge-->
                <div class="col">
                   <?= $form->field($model, "person_in_charge"); ?>
                </div>


            </div>

            <div class="row">
                <div class="col-12 col-lg-3">

                    <!-- Card Own Equipment -->
                   <?= $form->field($model, "card_own_equipment_id")
                      ->widget(Select2::class, [
                         'data' => CardOwnEquipment::find()->byCardId($quotation->customer_id),
                         'options' => [
                            'placeholder' => '= Pilih unit (jika ada) ='
                         ]
                      ]);
                   ?>

                    <!-- Hour meter -->
                   <?= $form->field($model, "hour_meter"); ?>

                </div>

                <div class="col-12 col-lg-9">

                    <!-- Mekaniks ID -->
                   <?= $form->field($model, 'mekaniksId')->widget(Select2::class, [
                      'data' => Card::find()->map(Card::GET_ONLY_MEKANIK),
                      'pluginOptions' => [
                         'multiple' => true
                      ],
                      'options' => [
                         'placeholder' => 'Pilih mekanik - mekanik'
                      ]
                   ]); ?>

                    <!-- Issue -->
                   <?= $form->field($model, "issue")->textarea([
                      'rows' => 4
                   ]); ?>

                    <!-- Remarks -->
                   <?= $form->field($model, "remarks")->textarea([
                      'rows' => 4
                   ]); ?>
                </div>
            </div>
        </div>

        <div class="card-footer p-3">
            <div class="d-flex justify-content-between">
               <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
               <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>


   <?php ActiveForm::end() ?>
</div>