<?php


/* @var $this View */
/* @see \app\controllers\StockPerGudangController::actionBarangMasukTandaTerimaPoStep1() */

/* @var $model StockPerGudangBarangMasukDariTandaTerimaPoForm */

use app\models\form\StockPerGudangBarangMasukDariTandaTerimaPoForm;
use app\models\TandaTerimaBarang;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap5\Html;
use yii\web\View;


$this->title = 'Set Lokasi Tanda Terima P.O';
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Step 1. ' . $this->title;

?>

<div class="stock-per-gudang-form">

    <h1>Step 1</h1>

   <?php $form = ActiveForm::begin() ?>

   <?= $form->field($model, 'nomorTandaTerimaId')
      ->label('Nomor Tanda Terima')
      ->hint('Pilih tanda terima yang belum masuk gudang')
      ->widget(Select2::class, [
         'data' => TandaTerimaBarang::find()->mapBelumAdaDataLokasi()
      ]);
   ?>

    <div class="d-flex justify-content-between mt-3">
       <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
       <?= Html::submitButton(' Cari', ['class' => 'btn btn-primary']) ?>
    </div>

   <?php ActiveForm::end() ?>
</div>