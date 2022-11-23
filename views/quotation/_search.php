<?php

use app\enums\TextLinkEnum;
use app\models\Card;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\search\QuotationSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="quotation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => ActiveForm::TYPE_INLINE,
        'tooltipStyleFeedback' => true, // shows tooltip styled validation error feedback
        'fieldConfig' => ['options' => ['class' => 'form-group me-1']], // spacing field groups
        'formConfig' => ['showErrors' => true],
        'options' => ['style' => 'align-items: flex-start']
    ]); ?>


    <?= $form->field($model, 'nomor') ?>
    <?= $form->field($model, 'customer_id')->widget(Select2::class, [
        'data' => Card::find()->map(),
        'options' => [
            'placeholder' => "= Pilih Customer ="
        ],
    ]) ?>

    <div class="form-group me-1">
        <div class="d-flex flex-row gap-1">
            <?= Html::submitButton(TextLinkEnum::SEARCH->value, ['class' => 'btn btn-primary']) ?>
            <div class="ms-auto">
                <?= Html::a('<i class="bi bi-repeat"></i>', ['index'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>