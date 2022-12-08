<?php

use app\enums\TextLinkEnum;
use app\models\ProformaInvoice;
use app\models\ProformaInvoiceDetailService;
use app\models\Quotation;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\Html;
use yii\db\ActiveRecord;
use yii\web\View;


/* @var $this View */
/* @var $quotation Quotation */
/* @var $model ProformaInvoice|string|ActiveRecord */
/* @var $modelsDetail ProformaInvoiceDetailService[]|string */

?>

<div class="quotation-form">
   <?php $form = ActiveForm::begin([
      'id' => 'dynamic-form'
   ]) ?>

   <?php DynamicFormWidget::begin([
      'widgetContainer' => 'dynamicform_wrapper',
      'widgetBody' => '.container-items',
      'widgetItem' => '.item',
      'limit' => 100,
      'min' => 1,
      'insertButton' => '.add-item',
      'deleteButton' => '.remove-item',
      'model' => $modelsDetail[0],
      'formId' => 'dynamic-form',
      'formFields' => ['id', 'job_description', 'hours', 'rate_per_hour', 'discount'],
   ]); ?>

   <div class="d-flex flex-column gap-3 container-items">

      <?php foreach ($modelsDetail as $i => $model) : ?>

         <div class="card rounded border-0 shadow item">

            <div class="card-header d-flex justify-content-between">
               <?php if (!$model->isNewRecord) {
                  echo Html::activeHiddenInput($model, "[$i]id");
               } ?>

               <?= Html::tag('span', 'Quotation Service', ['class' => 'fw-bold']) ?>
               <?= Html::button('<i class="bi bi-x-lg"> </i>', [
                  'class' => 'remove-item btn btn-danger btn-sm rounded-circle'
               ]) ?>
            </div>

            <div class="card-body">

               <div class="row row-cols-2 row-cols-lg-4">

                  <!-- Job description -->
                  <div class="col">
                     <?= $form->field($model, "[$i]job_description") ?>
                  </div>

                  <!-- Hours-->
                  <div class="col">
                     <?= $form->field($model, "[$i]hours");
                     ?>
                  </div>

                  <!-- Rate Per Hour -->
                  <div class="col">
                     <?= $form->field($model, "[$i]rate_per_hour")->widget(NumberControl::class, [
                        'maskedInputOptions' => [
                           'prefix' => $quotation->mataUang->singkatan,
                           'allowMinus' => false
                        ],
                     ]) ?>
                  </div>

                  <!-- Discount -->
                  <div class="col">
                     <?= $form->field($model, "[$i]discount")->textInput([
                        'class' => 'form-control quantity',
                        'type' => 'number'
                     ]) ?>
                  </div>

               </div>

            </div>
         </div>
      <?php endforeach; ?>
   </div>

   <div class="d-flex justify-content-center my-2">
      <?php echo Html::button(TextLinkEnum::TAMBAH->value, ['class' => 'add-item btn btn-primary']); ?>
   </div>

   <?php DynamicFormWidget::end() ?>


   <div class="d-flex justify-content-between">
      <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
      <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
   </div>
   <?php ActiveForm::end() ?>

</div>