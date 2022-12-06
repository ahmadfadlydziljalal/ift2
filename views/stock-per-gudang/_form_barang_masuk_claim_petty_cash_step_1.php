<?php

use app\models\form\StockPerGudangBarangMasukDariClaimPettyCashForm;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;


/* @var $this View */
/* @var $model StockPerGudangBarangMasukDariClaimPettyCashForm */
/* @see \app\controllers\StockPerGudangController::actionBarangMasukClaimPettyCashStep1() */

$this->title = 'Set Lokasi Claim Petty Cash';
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Step 1. ' . $this->title;
?>

<div class="stock-per-gudang-form">

    <h1>Step 1</h1>

   <?php $form = ActiveForm::begin() ?>

   <?= $form->field($model, 'nomorClaimPettyCashId')
      ->label('Nomor Claim Petty Cash')
      ->hint('Pilih claim petty cash yang beli barang stock')
      ->widget(Select2::class, [
         'initValueText' => '',
         'options' => ['placeholder' => 'Cari claim petty cash yang di dalamnya ada pembelian stock barang'],
         'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
               'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
               /** @see \app\controllers\StockPerGudangController::actionFindClaimPettyCash() */
               'url' => Url::to(['/stock-per-gudang/find-claim-petty-cash']),
               'dataType' => 'json',
               'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
         ],
      ]);
   ?>

    <div class="d-flex justify-content-between mt-3">
       <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
       <?= Html::submitButton(' Cari', ['class' => 'btn btn-primary']) ?>
    </div>

   <?php ActiveForm::end() ?>
</div>