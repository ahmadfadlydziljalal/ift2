<?php

use app\models\Card;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClaimPettyCash */
/* @var $modelsDetail app\models\ClaimPettyCashNota */
/* @var $modelsDetailDetail app\models\ClaimPettyCashNotaDetail */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="claim-petty-cash-form">

    <?php $form = ActiveForm::begin([

        'id' => 'dynamic-form',
        'layout' => ActiveForm::LAYOUT_HORIZONTAL,
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4 col-form-label',
                'offset' => 'offset-sm-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],

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
                    <?php echo $form->field($model, 'vendor_id')->widget(Select2::class, [
                        'data' => Card::find()->map(Card::GET_ONLY_VENDOR),
                        'options' => [
                            'prompt' => '= Pilih Kantor / Personal IFT =',
                            'autofocus' => 'autofocus'
                        ],
                    ]) ?>
                    <?php echo $form->field($model, 'tanggal')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]); ?>
                    <?php echo $form->field($model, 'remarks')->textarea(['rows' => 5]); ?>
                    <?php echo $form->field($model, 'approved_by')->textInput(['maxlength' => true]); ?>
                    <?php echo $form->field($model, 'acknowledge_by')->textInput(['maxlength' => true]); ?>
                </div>
            </div>
        </div>

        <div class="form-detail">

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 100, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsDetail[0],
                'formId' => 'dynamic-form',
                'formFields' => ['id', 'claim_petty_cash_id', 'nomor', 'vendor_id',],
            ]); ?>

            <div class="container-items">

                <?php foreach ($modelsDetail as $i => $modelDetail): ?>
                    <div class="card mb-4 item">

                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <?php if (!$modelDetail->isNewRecord) {
                                    echo Html::activeHiddenInput($modelDetail, "[$i]id");
                                } ?>
                                <strong><i class="bi bi-arrow-right-short"></i> Nota</strong>
                                <button type="button" class="remove-item btn btn-link text-danger">
                                    <i class="bi bi-x-circle"> </i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <?= $form->field($modelDetail, "[$i]nomor", ['options' => ['class' => 'mb-3 row']]); ?>
                            <?= $form->field($modelDetail, "[$i]vendor_id", ['options' => ['class' => 'mb-3 row']])->widget(Select2::class, [
                                'data' => Card::find()->map(Card::GET_ONLY_VENDOR),
                                'options' => [
                                    'prompt' => '= Pilih Vendor',
                                    'autofocus' => 'autofocus'
                                ],
                            ]) ?>
                        </div>

                        <?= $this->render('_form-detail-detail', [
                            'form' => $form,
                            'i' => $i,
                            'modelsDetailDetail' => $modelsDetailDetail[$i],
                        ]) ?>

                    </div>

                <?php endforeach; ?>
            </div>

            <div class="text-end">
                <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah Nota', ['class' => 'add-item btn btn-success',]); ?>
            </div>

            <?php DynamicFormWidget::end(); ?>

            <div class="d-flex justify-content-between mt-3">
                <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton(' Simpan', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>