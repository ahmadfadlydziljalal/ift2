<?php


/* @var $this View */
/* @var $model StockPerGudangBarangMasukDariTandaTerimaPoForm */

/* @var $modelsDetail array */
/* @var $modelDetail TandaTerimaBarangDetail $modelDetail */
/* @var $modelsDetailDetail array */

/* @see \app\controllers\StockPerGudangController::actionBarangMasukTandaTerimaPoStep2() */

use app\models\form\StockPerGudangBarangMasukDariTandaTerimaPoForm;
use app\models\TandaTerimaBarangDetail;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\Alert;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

$this->title = 'Step 2. Set Lokasi Tanda Terima P.O';
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Step 1', 'url' => ['barang-masuk-tanda-terima-po-step1']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="stock-per-gudang-form">

    <div class="d-flex justify-content-between mb-3">
        <h1>Step 2</h1>
       <?= Html::a($model->tandaTerimaBarang->nomor, ['/tanda-terima-barang/print', 'id' => $model->tandaTerimaBarang->id], [
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
      'formFields' => ['id', 'quantity_terima'],
   ]);
   ?>

    <div class="container-items">
       <?php foreach ($modelsDetail as $i => $modelDetail): ?>
           <div class="card bg-transparent mb-4 item">
               <div class="card-body">

                  <?= Html::activeHiddenInput($modelDetail, "[$i]id"); ?>
                  <?= Html::activeHiddenInput($modelDetail, "[$i]quantity_terima"); ?>

                  <?= DetailView::widget([
                     'model' => $modelDetail,
                     'attributes' => [
                        [
                           'label' => 'Quantity Pesan',
                           'value' => function ($modelDetail) {
                              return $modelDetail->materialRequisitionDetailPenawaran->quantity_pesan;
                           }
                        ],
                        'quantity_terima',
                        [
                           'label' => 'Barang',
                           'value' => function ($modelDetail) {
                              return
                                 $modelDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->part_number . ' - ' .
                                 $modelDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->merk_part_number . ' - ' .
                                 $modelDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->nama;
                           }
                        ]
                     ]
                  ]) ?>

                   <div class="table-responsive ">

                      <?php if ($modelDetail->getFirstError('quantity_terima')) : ?>
                         <?= Alert::widget([
                            'body' => $modelDetail->getFirstError('quantity_terima'),
                            'options' => [
                               'class' => 'alert alert-danger'
                            ]
                         ]) ?>
                      <?php endif ?>

                      <?= $this->render('_form-detail-detail_step_2', [
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
       <?php echo Html::a(' Step 1', ['stock-per-gudang/barang-masuk-tanda-terima-po-step1'], ['class' => 'btn btn-secondary']) ?>
       <?php echo Html::submitButton(' Simpan Data', ['class' => 'btn btn-primary']) ?>
    </div>

   <?php ActiveForm::end() ?>
</div>