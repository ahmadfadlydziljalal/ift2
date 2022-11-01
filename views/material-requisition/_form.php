<?php

use app\models\Card;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MaterialRequisition */
/* @var $modelsDetail app\models\MaterialRequisitionDetail */
/* @var $form yii\bootstrap5\ActiveForm */

$fieldConfig = [
    'template' => '<div class="mb-3 row"><div class="col-sm-3">{label}</div><div class="col-sm-9">{input}{error}</div> </div>'
];

?>

<div class="material-requisition-form">

    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
        'errorSummaryCssClass' => 'alert alert-danger'

        /*'layout' => ActiveForm::LAYOUT_FLOATING,
        'fieldConfig' => [
            'options' => [
            'class' => 'form-floating'
            ]
        ]*/
    ]); ?>

    <div class="d-flex flex-column mt-0" style="gap: 1rem">

        <div class="form-master">
            <div class="row">
                <div class="col-12 col-lg-7">

                    <?= $form->field($model, 'vendor_id', $fieldConfig)->widget(Select2::class, [
                        'data' => Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR),
                        'pluginOptions' => [
                            'placeholder' => '= Pilih orang kantor =',
                            'autofocus' => 'autofocus'
                        ]
                    ])->hint(false) ?>
                    <?= $form->field($model, 'tanggal', $fieldConfig)->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
                    <?= $form->field($model, 'remarks', $fieldConfig)->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'approved_by', $fieldConfig)->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'acknowledge_by', $fieldConfig)->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <?= $this->render('_form_detail', [
            'form' => $form,
            'modelsDetail' => $modelsDetail
        ]) ?>

        <div class="d-flex justify-content-between">
            <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
            <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>