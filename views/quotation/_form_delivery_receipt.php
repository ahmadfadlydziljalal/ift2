<?php

use app\models\Quotation;
use app\models\QuotationDeliveryReceiptDetail;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $quotation Quotation */
/* @var $model app\models\QuotationDeliveryReceipt */
/* @var $modelsDetail app\models\QuotationDeliveryReceiptDetail */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="quotation-delivery-receipt-form">

   <?php $form = ActiveForm::begin([
      'id' => 'dynamic-form',

   ]); ?>

   <?= $form->errorSummary($model) ?>

    <div class="card">

        <div class="card-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-2 col-lg-4">
                   <?= $form->field($model, 'tanggal')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>

                </div>
                <div class="col-12 col-sm-12 col-md-2 col-lg-4">
                   <?= $form->field($model, 'purchase_order_number')->textInput(['maxlength' => true]) ?>

                </div>
                <div class="col-12 col-sm-12 col-md-2 col-lg-4">
                   <?= $form->field($model, 'checker')->textInput(['maxlength' => true]) ?>

                </div>
                <div class="col-12 col-sm-12 col-md-2 col-lg-4">
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
                        <th scope="col">Total Qty. sudah dikirim</th>
                        <th scope="col">Total Qty. pengiriman dokumen ini</th>
                    </tr>
                    </thead>

                    <tbody class="container-items">

                    <?php /** @var QuotationDeliveryReceiptDetail $modelDetail */
                    foreach ($modelsDetail as $i => $modelDetail): ?>
                        <!--                        <tr>-->
                        <!--                            <td colspan="4">-->
                        <!--                               --><?php //Html::tag('pre', VarDumper::dumpAsString($modelDetail)) ?>
                        <!--                            </td>-->
                        <!--                        </tr>-->
                        <tr class="item align-middle">

                            <td style="width: 2px;" class="align-middle">
                               <?php if (!$modelDetail->isNewRecord) {
                                  echo Html::activeHiddenInput($modelDetail, "[$i]id");
                               } ?>
                               <?= Html::activeHiddenInput($modelDetail, "[$i]quotation_barang_id") ?>

                                <i class="bi bi-arrow-right-short"></i>
                            </td>

                            <td>
                               <?= $modelDetail->quotationBarang->barang->nama ?> |
                               <?= $modelDetail->quotationBarang->quantity ?> |
                               <?= $modelDetail->quotationBarang->satuan->nama ?>
                            </td>

                            <td>
                               <?= $modelDetail->quotationBarang->totalQuantitySudahTerkirimSpecificQuotationBarang($modelDetail->quotation_barang_id) ?? "0.00" ?>

                            </td>

                            <td><?= $form->field($modelDetail, "[$i]quantity", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])->textInput(['type' => 'number', 'class' => 'form-control']); ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
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