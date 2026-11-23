<?php

use app\enums\TipePembelianEnum;
use app\models\Barang;
use app\models\Originalitas;
use app\models\Satuan;
use app\models\TipePembelian;
use kartik\form\ActiveForm;
use yii\web\View;

/** @var $this View */
/** @var $form ActiveForm */
/** @var $model Barang */

?>

<div class="form-master">

    <div class="row">
        <div class="col-12 col-lg-6">
            <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'style' => ['text-transform' => 'uppercase']]) ?>
        </div>
        <div class="col-12 col-lg-6">
            <?= $form->field($model, 'part_number')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6">
            <?= $form->field($model, 'merk_part_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-12 col-lg-6">
            <?= $form->field($model, 'tipe_pembelian_id')
                    ->radioList(TipePembelian::find()->map([
                            TipePembelianEnum::STOCK->value,
                            TipePembelianEnum::PERLENGKAPAN->value,
                            TipePembelianEnum::INVENTARIS->value
                    ]), ['inline' => true]);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6">
            <?= $form->field($model, 'originalitas_id')->radioList(Originalitas::find()->map(), ['inline' => true]) ?>
        </div>
        <div class="col-12 col-lg-6">
            <?= $form->field($model, 'default_satuan_id')->dropDownList(Satuan::find()->map()) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-6">
            <?= $form->field($model, 'keterangan')->textarea(['rows' => '4']) ?>
        </div>
    </div>
</div>