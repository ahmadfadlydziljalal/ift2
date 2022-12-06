<?php


/* @var $this View */
/* @var $modelsDetail HistoryLokasiBarang[] */
/* @see \app\controllers\StockController::actionSetLokasi() */

/* @var $model SetLokasiBarangInForm */

use app\enums\TextLinkEnum;
use app\models\Card;
use app\models\form\SetLokasiBarangInForm;
use app\models\HistoryLokasiBarang;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = ucwords($model->tipePergerakan->key);
$this->params['breadcrumbs'][] = ['label' => 'Stock', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
   'label' => $model->tandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->nama,
   'url' => ['stock/view', 'id' => $model->tandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang_id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="stock-form">
    <h1>Set <?= Yii::$app->request->queryParams['type'] ?>
        : <?= $model->tandaTerimaBarangDetail->tandaTerimaBarang->nomor ?></h1>

    <div class="d-flex flex-column gap-3">
        <div>
            <span class="badge bg-primary"><?= $model->tandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->nama ?></span>
            <span class="badge bg-primary"><?= $model->tandaTerimaBarangDetail->quantity_terima ?></span>
            <span class="badge bg-primary"><?= $model->tandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->satuan->nama ?></span>
        </div>

        <div>
           <?php $form = ActiveForm::begin([
              'id' => 'dynamic-form'
           ]) ?>

           <?= $form->errorSummary($model, ['class' => 'alert alert-danger']) ?>

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
              'formFields' => ['id', 'block', 'rak', 'tier', 'row'],
           ]);
           ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Warehouse</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Block</th>
                        <th scope="col">Rak</th>
                        <th scope="col">Tier</th>
                        <th scope="col">Row</th>
                        <th scope="col" style="width:2px"></th>
                    </tr>
                    </thead>

                    <tbody class="container-items">

                    <?php /** @var HistoryLokasiBarang $detail */
                    foreach ($modelsDetail as $i => $detail): ?>
                        <tr class="item align-middle">

                            <td style="width: 2px;" class="align-middle">
                               <?php if (!$detail->isNewRecord) {
                                  echo Html::activeHiddenInput($detail, "[$i]id");
                               } ?>
                                <i class="bi bi-arrow-right-short"></i>
                            </td>

                            <td>
                               <?= $form->field($detail, "[$i]card_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                                  ->dropDownList(Card::find()->map(Card::GET_ONLY_WAREHOUSE)); ?>
                            </td>

                            <td>
                               <?= $form->field($detail, "[$i]quantity", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                                  'type' => 'number',
                                  'class' => 'form-control'
                               ]); ?>
                            </td>

                            <td>
                               <?= $form->field($detail, "[$i]block", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                            </td>

                            <td>
                               <?= $form->field($detail, "[$i]rak", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                            </td>

                            <td>
                               <?= $form->field($detail, "[$i]tier", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                            </td>

                            <td>
                               <?= $form->field($detail, "[$i]row", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
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
                        <th class="text-center" colspan="5">
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
               <?= Html::submitButton(' Simpan Data', ['class' => 'btn btn-success']) ?>
            </div>

           <?php ActiveForm::end() ?>
        </div>
    </div>
</div>