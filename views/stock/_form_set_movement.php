<?php


/* @var $this View */
/* @var $models SetLokasiBarangMovementFromForm[] */

/* @var $modelTandaTerimaBarangDetail TandaTerimaBarangDetail|null */

/* @var $movementBarangModel SetLokasiBarangMovementForm */

use app\models\form\SetLokasiBarangMovementForm;
use app\models\form\SetLokasiBarangMovementFromForm;
use app\models\TandaTerimaBarangDetail;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\Html;
use yii\web\View;


$this->title = "Movement";
$this->params['breadcrumbs'][] = ['label' => 'Stock', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
   'label' => $movementBarangModel->tandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->nama,
   'url' => ['stock/view', 'id' => $movementBarangModel->tandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang_id]];
$this->params['breadcrumbs'][] = $this->title;

?>

    <div class="stock-form">

        <h1>Set Movement
            : <?= $modelTandaTerimaBarangDetail->tandaTerimaBarang->nomor ?></h1>

        <div class="d-flex flex-column gap-3">
            <div>
                <span class="badge bg-primary"><?= $modelTandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->nama ?></span>
                <span class="badge bg-primary"><?= $modelTandaTerimaBarangDetail->quantity_terima ?></span>
                <span class="badge bg-primary"><?= $modelTandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->satuan->nama ?></span>
            </div>

            <div>
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
                  'model' => $models[0],
                  'formId' => 'dynamic-form',
                  'formFields' => ['id', 'block', 'rak', 'tier', 'row'],
               ]);
               ?>

                <div class="table-responsive">
                    <table class="table table-bordered">

                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Movement</th>
                        </tr>
                        </thead>

                        <tbody class="container-items">
                        <?php /** @var SetLokasiBarangMovementFromForm $model */
                        foreach ($models as $i => $model): ?>
                            <tr class="item align-middle">
                                <td style="width: 2px;" class="align-middle">
                                    <i class="bi bi-arrow-right-short"></i>
                                </td>
                                <td>
                                    <table class="table table-bordered m-0 t-account">

                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Quantity</th>
                                            <th>Block</th>
                                            <th>Rak</th>
                                            <th>Tier</th>
                                            <th>Row</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr class="align-middle">
                                            <td class="text-center">
                                                Sebelumnya:</i><?= Html::activeHiddenInput($model, "[$i]tipePergerakanFromId"); ?>
                                            </td>
                                            <td></td>
                                            <td><?= $form->field($model, "[$i]quantityFrom", ['template' =>
                                                  '{input}{error}{hint}', 'options' => ['class' => null]])
                                                  ->textInput([
                                                     'type' => 'number',
                                                     'class' => 'form-control quantity-from'
                                                  ]); ?>
                                            </td>
                                            <td><?= $form->field($model, "[$i]blockFrom", ['template' =>
                                                  '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                                                  'class' => 'form-control block-from'
                                               ]); ?>
                                            </td>
                                            <td> <?= $form->field($model, "[$i]rakFrom", ['template' =>
                                                  '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                                                  'class' => 'form-control rak-from'
                                               ]); ?></td>
                                            <td><?= $form->field($model, "[$i]tierFrom", ['template' =>
                                                  '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                                                  'class' => 'form-control tier-from'
                                               ]); ?></td>
                                            <td><?= $form->field($model, "[$i]rowFrom", ['template' =>
                                                  '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                                                  'class' => 'form-control row-from'
                                               ]); ?></td>

                                        </tr>

                                        </tbody>


                                    </table>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        </tbody>


                    </table>
                </div>

               <?php DynamicFormWidget::end() ?>

                <div class="d-flex justify-content-between">
                   <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
                   <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
                </div>

               <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>

<?php

$js = <<<JS
 function cloneFromValue(el){
    
    var button          = jQuery(el);
    var currentRow      = button.closest('tr'); 
    var prevRow         = button.closest('tr').prev();
    
    var quantityFromVal = prevRow.find('.quantity-from').val();
    var blockFromVal    = prevRow.find('.block-from').val();
    var rakFromVal      = prevRow.find('.rak-from').val();
    var tierFromVal     = prevRow.find('.tier-from').val();
    var rowFromVal      = prevRow.find('.row-from').val();
    
    currentRow.find('.quantity-to').val(quantityFromVal);
    currentRow.find('.block-to').val(blockFromVal);
    currentRow.find('.rak-to').val(rakFromVal);
    currentRow.find('.tier-to').val(tierFromVal);
    currentRow.find('.row-to').val(rowFromVal);
    
 }
JS;

$this->registerJs($js, View::POS_BEGIN);