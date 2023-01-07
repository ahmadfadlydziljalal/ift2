<?php

use app\enums\CaraPenulisanLokasiEnum;
use app\enums\TipePembelianEnum;
use app\models\Barang;
use app\models\form\StockPerGudangStartLocation;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap5\Html;
use yii\web\View;


/* @var $this View */
/* @var $model StockPerGudangStartLocation */

$this->title = 'Set Lokasi Barang | Start Project';
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="stock-per-gudang-form">

    <h1><?= Html::encode($this->title) ?></h1>

   <?php $form = ActiveForm::begin([
      'fieldConfig' => []
   ]) ?>

    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4">
           <?= $form->field($model, 'barangId')->widget(Select2::class, [
              'data' => Barang::find()->map(TipePembelianEnum::STOCK->value),
              'options' => [
                 'prompt' => '= Pilih Salah Satu ='
              ]
           ]) ?>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4">
           <?= $form->field($model, 'quantity')->textInput([
              'type' => 'number'
           ]) ?>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4">

        </div>

    </div>

    <div class="d-flex justify-content-center">
        <hr class="w-25"/>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-3">
        <div class="col">
           <?= $form->field($model, 'cardId')->widget(Select2::class, [
              'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::GUDANG),
              'options' => [
                 'prompt' => '= Pilih Salah Satu ='
              ]
           ]) ?>
        </div>
        <div class="col">
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                   <?= $form->field($model, 'block')
                      ->widget(Select2::class, [
                         'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::BLOCK),
                         'options' => [
                            'prompt' => '= Pilih Salah Satu ='
                         ]
                      ]);
                   ?>
                </div>
                <div class="col">
                   <?= $form->field($model, 'rak')->widget(Select2::class, [
                      'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::RAK),
                      'options' => [
                         'prompt' => '= Pilih Salah Satu ='
                      ]
                   ]) ?>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col">
                   <?= $form->field($model, 'tier')->widget(Select2::class, [
                      'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::TIER),
                      'options' => [
                         'prompt' => '= Pilih Salah Satu ='
                      ]
                   ]) ?>
                </div>
                <div class="col">
                   <?= $form->field($model, 'row')->widget(Select2::class, [
                      'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::ROW),
                      'options' => [
                         'prompt' => '= Pilih Salah Satu ='
                      ]
                   ]) ?>
                </div>
            </div>
        </div>

    </div>

   <?= $form->field($model, 'catatan')->textarea([
      'rows' => '4'
   ]) ?>

    <div class="d-flex justify-content-between mt-3">
       <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>

        <div>
           <?= Html::submitButton('<i class="bi bi-save-fill"></i> Simpan', ['class' => 'btn btn-primary', 'name' => 'Continue', 'value' => 0]) ?>
           <?= Html::submitButton('<i class="bi bi-save-fill"></i> Simpan & Lanjut Entry', ['class' => 'btn btn-primary', 'name' => 'Continue', 'value' => 1]) ?>
        </div>

    </div>

   <?php ActiveForm::end() ?>

</div>