<?php

use app\models\QuotationBarang;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuotationDeliveryReceipt */
/* @var $modelsDetail app\models\QuotationDeliveryReceiptDetail */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="quotation-delivery-receipt-form">

   <?php $form = ActiveForm::begin([
      'id' => 'dynamic-form',
   ]); ?>

    <div class="card">

        <div class="card-body">
            <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-4">
                <div class="col">
                   <?= $form->field($model, 'tanggal')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>

                </div>
                <div class="col">
                   <?= $form->field($model, 'purchase_order_number')->textInput(['maxlength' => true]) ?>

                </div>
                <div class="col">
                   <?= $form->field($model, 'checker')->textInput(['maxlength' => true]) ?>

                </div>
                <div class="col">
                   <?= $form->field($model, 'vehicle')->textInput(['maxlength' => true]) ?>

                </div>
            </div>
           <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

           <?php
           DynamicFormWidget::begin([
              'widgetContainer' => 'dynamicform_wrapper',
              'widgetBody' => '.container-items',
              'widgetItem' => '.item',
              'limit' => 100,
              'min' => 1,
              'insertButton' => '.add-item',
              'deleteButton' => '.remove-item',
              'model' => $modelsDetail[0],
              'formId' => 'dynamic-form',
              'formFields' => ['id', 'quotation_barang_id', 'quotation_delivery_receipt_id', 'quantity',],
           ]);
           ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Quotation barang</th>
                        <th scope="col">Quantity</th>
                        <th scope="col" style="width: 2px">Aksi</th>
                    </tr>
                    </thead>

                    <tbody class="container-items">

                    <?php foreach ($modelsDetail as $i => $modelDetail): ?>
                        <tr class="item">

                            <td style="width: 2px;" class="align-middle">
                               <?php if (!$modelDetail->isNewRecord) {
                                  echo Html::activeHiddenInput($modelDetail, "[$i]id");
                               } ?>
                                <i class="bi bi-arrow-right-short"></i>
                            </td>

                            <td><?= $form->field($modelDetail, "[$i]quotation_barang_id", ['template' =>
                                  '{input}{error}{hint}', 'options' => ['class' => null]])
                                  ->dropDownList(QuotationBarang::find()->byQuotationId($quotation->id), [
                                     'prompt' => '= Pilih salah satu ='
                                  ]) ?>
                            </td>
                            <td><?= $form->field($modelDetail, "[$i]quantity", ['template' =>
                                  '{input}{error}{hint}', 'options' => ['class' => null]])
                                  ->textInput([
                                     'type' => 'number',
                                     'class' => 'form-control'
                                  ]); ?></td>

                            <td>
                                <button type="button" class="remove-item btn btn-link text-danger">
                                    <i class="bi bi-trash"> </i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>

                    <tfoot>
                    <tr>
                        <td class="text-end" colspan="3">
                           <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-success',]); ?>
                        </td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

           <?php DynamicFormWidget::end(); ?>

            <div class="d-flex justify-content-between">
               <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
               <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

    </div>
   
   <?php ActiveForm::end(); ?>

</div>