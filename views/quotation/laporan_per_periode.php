<?php

use app\models\Card;
use app\models\form\LaporanQuotationPerPeriodForm;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model LaporanQuotationPerPeriodForm */
/* @see \app\controllers\QuotationController::actionLaporanPerPeriode() */


$this->title = 'Laporan Per Periode';
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="quotation-laporan-per-periode d-flex flex-column gap-3">
    <h1>Create <?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]) ?>
    <?= $form->field($model, 'periodType')->dropDownList($model::optionsPeriodType(), [
        'prompt' => 'Pilih Periode ...'
    ]) ?>
    <?= $form->field($model, 'periodYear') ?>
    <?= $form->field($model, 'periodMonthYear')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true,
            'startView' => 'year',
            'minViewMode' => 'months',
            'format' => 'mm-yyyy'
        ]
    ]) ?>
    <?= $form->field($model, 'periodDate')->widget(DatePicker::class, [
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd-mm-yyyy'
        ]
    ]) ?>
    <?= $form->field($model, 'periodDateRange', [
        'addon' => ['append' => ['content' => '<i class="bi bi-calendar"></i>']],
    ])->widget(kartik\daterange\DateRangePicker::class, [
        'convertFormat' => true,
        'useWithAddon' => true,
        'pluginOptions' => [
            'locale' => [
                'format' => 'd-m-Y',
                'separator' => ' sampai ',
            ],
            'opens' => 'top'
        ]
    ]) ?>

    <?= $form->field($model, 'customerId')->widget(Select2::class, [
        'data' => Card::find()->map(),
        'options' => [
            'placeholder' => "= Semua customer ="
        ],
    ]) ?>

    <div class="form-group">
        <div class="float-end">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="clearfix"></div>
    </div>
    <?php ActiveForm::end() ?>


</div>
