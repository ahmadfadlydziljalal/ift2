<?php

/** @var $this yii/web/view */
/** @var $model StockPerGudangTransferBarangAntarGudang */

/** @var $modelsDetail StockPerGudangTransferBarangAntarGudangDetail[] */

use app\enums\CaraPenulisanLokasiEnum;
use app\models\form\StockPerGudangTransferBarangAntarGudang;
use app\models\form\StockPerGudangTransferBarangAntarGudangDetail;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'Transfer Barang';
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="stock-per-gudang-form">

    <div class="d-flex justify-content-between flex-wrap align-items-center">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

   <?php $form = ActiveForm::begin([
      'id' => 'dynamic-form'
   ]) ?>

    <div class="row row-cols-1 row-cols-sm-1 rows-col-md-3 row-cols-lg-3">
        <div class="col">
           <?= $form->field($model, 'namaBarang')->widget(Select2::class, [
              'initValueText' => '',
              'options' => ['placeholder' => 'Cari barang tipe stock'],
              'pluginOptions' => [
                 'allowClear' => true,
                 'minimumInputLength' => 3,
                 'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                 ],
                 'ajax' => [
                    'url' => Url::to(['barang/find-type-stock']),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                 ],
                 'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                 'templateResult' => new JsExpression('function(city) { return city.text; }'),
                 'templateSelection' => new JsExpression('function (city) { return city.text; }'),
              ],
           ]); ?>
        </div>
        <div class="col">
           <?= $form->field($model, 'quantityOut')->textInput([
              'type' => 'number'
           ]) ?>
        </div>
        <div class="col">
           <?= $form->field($model, 'gudangAsal')
              ->widget(Select2::class, [
                 'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::GUDANG),
                 'options' => [
                    'prompt' => '= Pilih ='
                 ]
              ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col col-sm-12 col-md-2">
           <?= $form->field($model, 'block')->widget(Select2::class, [
              'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::BLOCK),
              'options' => [
                 'prompt' => '= Pilih ='
              ]
           ]); ?>
        </div>
        <div class="col col-sm-12 col-md-2">
           <?= $form->field($model, 'rak')->widget(Select2::class, [
              'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::RAK),
              'options' => [
                 'prompt' => '= Pilih ='
              ]
           ]); ?>
        </div>
        <div class="col col-sm-12 col-md-2">
           <?= $form->field($model, 'tier')->widget(Select2::class, [
              'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::TIER),
              'options' => [
                 'prompt' => '= Pilih ='
              ]
           ]); ?>
        </div>
        <div class="col col-sm-12 col-md-2">
           <?= $form->field($model, 'row')->widget(Select2::class, [
              'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::ROW),
              'options' => [
                 'prompt' => '= Pilih ='
              ]
           ]); ?>
        </div>
        <div class="col col-sm-12 col-md-4">
           <?= $form->field($model, 'catatan') ?>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <hr class="w-25"/>
    </div>

   <?php DynamicFormWidget::begin([
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
   ]); ?>

    <table class="table table-bordered m-0 p-0">

        <thead class="thead-light">
        <tr class="text-nowrap">
            <th scope="col">#</th>
            <th scope="col">Quantity</th>
            <th scope="col">Gudang Tujuan</th>
            <th scope="col">Block</th>
            <th scope="col">Rak</th>
            <th scope="col">Tier</th>
            <th scope="col">Row</th>
            <th scope="col">Catatan</th>
            <th scope="col" style="width:2px"></th>
        </tr>
        </thead>

        <tbody class="container-items">

        <?php $template = ['template' => '{input}{error}{hint}', 'options' => ['class' => null]] ?>
        <?php foreach ($modelsDetail as $i => $modelDetail): ?>
            <tr class="item">

                <td><i class="bi bi-arrow-right-short"></i></td>

                <td>
                   <?= $form->field($modelDetail, "[$i]quantityIn", $template)->textInput([
                      'type' => 'number'
                   ]); ?>
                </td>

                <td>
                   <?= $form->field($modelDetail, "[$i]gudangTujuan", $template)
                      ->widget(Select2::class, [
                         'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::GUDANG),
                         'options' => [
                            'prompt' => '= Pilih ='
                         ]
                      ]); ?>
                </td>

                <td>
                   <?= $form->field($modelDetail, "[$i]block", $template)
                      ->widget(Select2::class, [
                         'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::BLOCK),
                         'options' => [
                            'prompt' => '= Pilih ='
                         ]
                      ]); ?>
                </td>

                <td>
                   <?= $form->field($modelDetail, "[$i]rak", $template)
                      ->widget(Select2::class, [
                         'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::RAK),
                         'options' => [
                            'prompt' => '= Pilih ='
                         ]
                      ]); ?>
                </td>

                <td>
                   <?= $form->field($modelDetail, "[$i]tier", $template)
                      ->widget(Select2::class, [
                         'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::TIER),
                         'options' => [
                            'prompt' => '= Pilih ='
                         ]
                      ]); ?>
                </td>

                <td>
                   <?= $form->field($modelDetail, "[$i]row", $template)
                      ->widget(Select2::class, [
                         'data' => CaraPenulisanLokasiEnum::getDropdown(CaraPenulisanLokasiEnum::ROW),
                         'options' => [
                            'prompt' => '= Pilih ='
                         ]
                      ]);
                   ?>
                </td>

                <td>
                   <?= $form->field($modelDetail, "[$i]catatan", $template) ?>
                </td>

                <td class="text-center" style="width: 2px;">
                    <button type="button" class="remove-item btn btn-link text-danger px-2">
                        <i class="bi bi-trash"> </i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

        <tfoot>
        <tr>
            <td colspan="8" class="text-end">
               <?= Html::button('<span class="bi bi-plus-circle"></span> Tambah Gudang Tujuan', [
                  'class' => 'add-item btn btn-success',
               ]);
               ?>
            </td>
            <td></td>
        </tr>
        </tfoot>

    </table>

   <?php DynamicFormWidget::end() ?>

    <div class="d-flex justify-content-between mt-3">
       <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
       <?= Html::submitButton(' Simpan', ['class' => 'btn btn-primary']) ?>
    </div>

   <?php ActiveForm::end() ?>

</div>