<?php

use app\enums\TextLinkEnum;
use app\models\Card;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap5\ButtonDropdown;
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
        'tooltipStyleFeedback' => true, // shows a tooltip styled validation error feedback
        'fieldConfig' => ['options' => ['class' => 'form-group me-0']], // spacing field groups
        'formConfig' => ['showErrors' => true],
        'options' => [
            'class' => 'gap-0'
        ]
        //'options' => ['style' => 'align-items: flex-start']
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
                <?= Html::a('<i class="bi bi-repeat"></i> Refresh', ['index'], ['class' => 'btn btn-primary']) ?>
                <?= ButtonDropdown::widget([
                    'label' => TextLinkEnum::BUTTON_DROPDOWN_REPORTS->value,
                    'dropdown' => [
                        'items' => [
                            [
                                'label' => '<span class="bi bi-file"></span> Per Periode',
                                'url' => ['quotation/laporan-per-periode']
                            ],
                            [
                                'label' => '<span class="bi bi-file"></span> Outgoing',
                                'url' => ['quotation/laporan-outgoing']
                            ],
                        ],
                        'encodeLabels' => false,
                    ],
                    'encodeLabel' => false,
                    'buttonOptions' => [
                        'class' => 'btn btn-secondary'
                    ]
                ]) ?>
                <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>