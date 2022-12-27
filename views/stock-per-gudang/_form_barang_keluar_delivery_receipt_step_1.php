<?php

use app\models\form\StockPerGudangBarangKeluarDariDeliveryReceiptForm;
use app\models\QuotationDeliveryReceiptDetail;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model StockPerGudangBarangKeluarDariDeliveryReceiptForm */

$this->title = 'Step 1: Keluar Stock dari Quotation Delivery Receipt ';
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="stock-per-gudang-form">

    <h1><?= Html::encode($this->title) ?></h1>
   <?php $form = ActiveForm::begin() ?>

    <div class="row">
        <div class="col-12 col-md-8 col-lg-4">

           <?= $form->field($model, 'nomorDeliveryReceiptId')->dropDownList(
              QuotationDeliveryReceiptDetail::find()->mapBelumMasukLokasi(true, ['quotation_delivery_receipt_detail.quotation_delivery_receipt_id'])
           ) ?>

            <div class="d-flex justify-content-between mt-3">
               <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
               <?= Html::submitButton(' Cari', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>


   <?php ActiveForm::end() ?>
</div>