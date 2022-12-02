<?php


/* @var $this View */

/* @var $models HistoryLokasiBarang[] */

/* @var $modelTandaTerimaBarangDetail TandaTerimaBarangDetail */

use app\enums\TextLinkEnum;
use app\models\HistoryLokasiBarang;
use app\models\TandaTerimaBarangDetail;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = 'Set In ';
$this->params['breadcrumbs'][] = ['label' => 'Stock', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="stock-form">
    <h1>Set <?= Yii::$app->request->queryParams['type'] ?>
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
                        <th scope="col">Quantity</th>
                        <th scope="col">Block</th>
                        <th scope="col">Rak</th>
                        <th scope="col">Tier</th>
                        <th scope="col">Row</th>
                        <th scope="col" style="width:2px"></th>
                    </tr>
                    </thead>

                    <tbody class="container-items">

                    <?php /** @var HistoryLokasiBarang $model */
                    foreach ($models as $i => $model): ?>
                        <tr class="item align-middle">

                            <td style="width: 2px;" class="align-middle">
                               <?php if (!$model->isNewRecord) {
                                  echo Html::activeHiddenInput($model, "[$i]id");
                               } ?>
                                <i class="bi bi-arrow-right-short"></i>
                            </td>

                            <td>
                               <?= $form->field($model, "[$i]quantity", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                                  'type' => 'number',
                                  'class' => 'form-control'
                               ]); ?>
                            </td>

                            <td>
                               <?= $form->field($model, "[$i]block", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                            </td>

                            <td>
                               <?= $form->field($model, "[$i]rak", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                            </td>

                            <td>
                               <?= $form->field($model, "[$i]tier", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                            </td>

                            <td>
                               <?= $form->field($model, "[$i]row", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                            </td>

                            <td>
                               <?= Html::button('<i class="bi bi-trash"> </i>', [
                                  'class' => 'btn btn-link remove-item text-danger'
                               ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th></th>
                        <th class="text-center" colspan="4">
                           <?php echo Html::button(TextLinkEnum::TAMBAH->value, ['class' => 'add-item btn btn-primary']); ?>
                        </th>
                        <th></th>
                    </tr>
                    </tfoot>
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