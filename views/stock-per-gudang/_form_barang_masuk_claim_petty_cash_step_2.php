<?php

use app\models\form\StockPerGudangBarangMasukDariClaimPettyCashForm;
use app\models\HistoryLokasiBarang;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\Alert;
use yii\bootstrap5\Html;
use yii\db\ActiveQuery;
use yii\web\View;
use yii\widgets\DetailView;


/* @var $this View */
/* @var $model StockPerGudangBarangMasukDariClaimPettyCashForm */
/* @var $modelsDetail ActiveQuery */
/* @var $modelsDetailDetail HistoryLokasiBarang[][]|array */
/* @see \app\controllers\StockPerGudangController::actionBarangMasukClaimPettyCashStep2() */

$this->title = 'Step 2. Set Lokasi Claim Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Step 1', 'url' => ['barang-masuk-claim-petty-cash-step1']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="stock-per-gudang-form">
    <div class="d-flex justify-content-between mb-3">
        <h1>Step 2</h1>
       <?= Html::a($model->claimPettyCash->nomor, ['/claim-petty-cash/print', 'id' => $model->claimPettyCash->id], [
          'class' => 'btn btn-primary',
          'target' => '_blank'
       ]) ?>
    </div>

   <?php $form = ActiveForm::begin([
      'id' => 'dynamic-form'
   ]); ?>

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

                  <?= Html::activeHiddenInput($modelDetail, "[$i]id"); ?>
                  <?= Html::activeHiddenInput($modelDetail, "[$i]barang_id"); ?>
                  <?= Html::activeHiddenInput($modelDetail, "[$i]description"); ?>
                  <?= Html::activeHiddenInput($modelDetail, "[$i]quantity"); ?>
                  <?= Html::activeHiddenInput($modelDetail, "[$i]satuan_id"); ?>
                  <?= Html::activeHiddenInput($modelDetail, "[$i]harga"); ?>

                  <?= DetailView::widget([
                     'model' => $modelDetail,
                     'attributes' => [
                        [
                           'label' => 'Barang',
                           'value' => function ($modelDetail) {
                              return
                                 $modelDetail->barang->part_number . ' - ' .
                                 $modelDetail->barang->merk_part_number . ' - ' .
                                 $modelDetail->barang->nama;
                           }
                        ],
                        'quantity',
                     ]
                  ]) ?>

                   <div class="table-responsive">

                      <?php if ($modelDetail->getFirstError('quantity')) : ?>
                         <?= Alert::widget([
                            'body' => $modelDetail->getFirstError('quantity'),
                            'options' => [
                               'class' => 'alert alert-danger'
                            ]
                         ]) ?>
                      <?php endif ?>

                      <?= $this->render('_form-detail-detail_claim_petty_cash_step_2', [
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
       <?php echo Html::a(' Step 1', ['stock-per-gudang/barang-masuk-claim-petty-cash-step1'], ['class' => 'btn btn-secondary']) ?>
       <?php echo Html::submitButton(' Simpan Data', ['class' => 'btn btn-primary']) ?>
    </div>

   <?php ActiveForm::end(); ?>
</div>