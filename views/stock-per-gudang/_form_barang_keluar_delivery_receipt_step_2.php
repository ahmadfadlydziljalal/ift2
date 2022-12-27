<?php

use app\models\form\StockPerGudangBarangKeluarDariDeliveryReceiptForm;
use app\models\HistoryLokasiBarang;
use app\models\QuotationDeliveryReceiptDetail;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\Alert;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/** @var $this View */
/** @var $model StockPerGudangBarangKeluarDariDeliveryReceiptForm */
/** @var $modelsDetail QuotationDeliveryReceiptDetail[] */
/** @var $modelsDetailDetail HistoryLokasiBarang[] */

$this->title = 'Step 2. Set Lokasi Delivery Receipt';
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Step 1', 'url' => ['barang-keluar-delivery-receipt-step1']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="stock-per-gudang-form">
    <div class="d-flex justify-content-between mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
       <?= Html::a($model->quotationDeliveryReceipt->nomor, ['quotation/print-delivery-receipt', 'id' => $model->quotationDeliveryReceipt->id], [
          'class' => 'btn btn-primary',
          'target' => '_blank'
       ]) ?>
    </div>
   <?php $form = ActiveForm::begin([
      'id' => 'dynamic-form'
   ]) ?>
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
      'formFields' => ['id', 'quantity'],
   ]);
   ?>

    <div class="container-items">
       <?php foreach ($modelsDetail as $i => $modelDetail): ?>
           <div class="card bg-transparent mb-4 item">
               <div class="card-body">

                  <?php echo Html::activeHiddenInput($modelDetail, "[$i]id"); ?>
                  <?php echo Html::activeHiddenInput($modelDetail, "[$i]quotation_barang_id"); ?>
                  <?php echo Html::activeHiddenInput($modelDetail, "[$i]quotation_delivery_receipt_id"); ?>
                  <?php echo Html::activeHiddenInput($modelDetail, "[$i]quantity"); ?>
                  <?php echo Html::activeHiddenInput($modelDetail, "[$i]quantity_indent"); ?>

                  <?php echo DetailView::widget([
                     'model' => $modelDetail,
                     'attributes' => [
                        //'id',
                        [
                           'attribute' => 'quotation_barang_id',
                           'value' => $modelDetail->quotationBarang->quotation->nomor
                        ],
                        [
                           'attribute' => 'quotation_delivery_receipt_id',
                           'value' => $modelDetail->quotationDeliveryReceipt->nomor
                        ],
                        [
                           'label' => 'Barang / Satuan',
                           'value' => $modelDetail->quotationBarang->barang->nama . ' / ' . $modelDetail->quotationBarang->satuan->nama
                        ],
                        'quantity',
                        'quantity_indent',
                     ]
                  ]) ?>

                   <div class="table-responsive ">

                      <?php if ($modelDetail->getFirstError('quantity')) : ?>
                         <?php echo Alert::widget([
                            'body' => $modelDetail->getFirstError('quantity'),
                            'options' => [
                               'class' => 'alert alert-danger'
                            ]
                         ]) ?>
                      <?php endif ?>

                      <?php echo $this->render('_form-detail-detail_step_2', [
                         'form' => $form,
                         'i' => $i,
                         'modelsDetailDetail' => $modelsDetailDetail[$i],
                      ]) ?>

                   </div>
               </div>
           </div>

       <?php endforeach; ?>
    </div>

   <?php DynamicFormWidget::end() ?>

    <div class="d-flex justify-content-between mt-3">
       <?php echo Html::a('<i class="bi bi-arrow-left"></i> Kembali ke step 1', ['stock-per-gudang/barang-keluar-delivery-receipt-step1'], ['class' => 'btn btn-secondary']) ?>
       <?php echo Html::submitButton(' Simpan Data', ['class' => 'btn btn-primary']) ?>
    </div>

   <?php ActiveForm::end() ?>

</div>