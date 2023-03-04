<?php

use app\enums\TipePembelianEnum;
use app\models\Barang;
use app\models\Originalitas;
use app\models\Satuan;
use app\models\TipePembelian;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\web\View;

/** @var $this View */
/** @var $form ActiveForm */
/** @var $model Barang */

?>

<div class="form-master">
    <div class="row">
        <div class="col-12 col-lg-7">

           <?= $form->field($model, 'tipe_pembelian_id')->widget(Select2::class, [
              'data' => TipePembelian::find()->map([TipePembelianEnum::STOCK->value, TipePembelianEnum::PERLENGKAPAN->value, TipePembelianEnum::INVENTARIS->value]),
              'pluginOptions' => [
                 'autofocus' => 'autofocus',
                 'placeholder' => '= Pilih salah satu ='
              ]
           ]) ?>

           <?= $form->field($model, 'nama')->textInput([
              'maxlength' => true,
              'style' => [
                 'text-transform' => 'uppercase'
              ]
           ]) ?>
           
           <?= $form->field($model, 'part_number')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'merk_part_number')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'originalitas_id', ['inline' => true])->radioList(Originalitas::find()->map()) ?>
           <?= $form->field($model, 'initialize_stock_quantity')->textInput(['type' => 'number']) ?>
           <?= $form->field($model, 'default_satuan_id')->dropDownList(Satuan::find()->map()) ?>
           <?= $form->field($model, 'keterangan')->textarea(['rows' => '4']) ?>

        </div>
    </div>
</div>