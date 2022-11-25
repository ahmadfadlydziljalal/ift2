<?php


/* @var $this View */
/* @var $model QuotationDeliveryReceipt|string|ActiveRecord */

/* @var $quotation Quotation */

use app\models\Quotation;
use app\models\QuotationDeliveryReceipt;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;
use yii\db\ActiveRecord;
use yii\web\View;


?>

<div class="quotation-form">
   <?php $form = ActiveForm::begin() ?>

    <div class="card rounded border-0 shadow item">

        <div class="card-header d-flex justify-content-between">
           <?= Html::tag('span', 'Delivery Receipt', ['class' => 'fw-bold']) ?>
        </div>

        <div class="card-body">

            <div class="row row-cols-2 row-cols-lg-4">

                <!-- Tanggal -->
                <div class="col">
                   <?= $form->field($model, "tanggal")->widget(DateControl::class, [
                      'type' => DateControl::FORMAT_DATE
                   ]); ?>
                </div>

                <!-- P.O Customer -->
                <div class="col">
                   <?= $form->field($model, "purchase_order_number"); ?>
                </div>

                <!-- Checker -->
                <div class="col">
                   <?= $form->field($model, "checker"); ?>
                </div>

                <!-- Vehicle -->
                <div class="col">
                   <?= $form->field($model, "vehicle"); ?>
                </div>
            </div>

           <?= $form->field($model, "remarks")->textarea([
              'rows' => 4
           ]); ?>

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