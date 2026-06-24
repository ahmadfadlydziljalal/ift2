<?php

/* @var $this yii\web\View */

/* @var $model app\models\form\ImportMaterialRequestForm */

/* @see \app\controllers\MaterialRequisitionController::actionImport() */


use kartik\file\FileInput;
use kartik\form\ActiveForm;
use yii\helpers\Html;

$this->title = 'Import Material Request';
$this->params['breadcrumbs'][] = ['label' => 'Material Requisition', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="material-requisition-import">
    <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>

    <div class="row">
        <div class="col-sm-12 col-md-10 order-sm-2 order-md-1">
            <?= $form->field($model, 'file')->widget(FileInput::class, [
                'options'       => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
                'pluginOptions' => [
                    'showUpload'  => false,
                    'showCaption' => false,
                    'showRemove'  => false,
                ]
            ]) ?>
            <div class="d-flex justify-content-end">
                <div class="form-group">
                    <?= Html::submitButton('Import', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-2 order-sm-1 order-md-2">
            <h4>Column Format</h4>
            <ol type="A">
                <li>No</li>
                <li>Part Number</li>
                <li>Description</li>
                <li>Kode Vendor</li>
                <li>Qty</li>
                <li>Price / Item</li>
                <li>Total Price</li>
                <li>Stock</li>
                <li>Remark</li>
            </ol>
        </div>
    </div>


    <?php ActiveForm::end() ?>

</div>

