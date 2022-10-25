<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html as Bootstrap5Html;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CardPersonInCharge */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="card-person-in-charge-form">

    <?php $form = ActiveForm::begin([

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

    <div class="row">
        <div class="col-12 col-lg-8">

            <p class="badge text-bg-dark"><?= $model->card->nama ?></p>
            <?= Bootstrap5Html::activeHiddenInput($model, 'card_id') ?>

            <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'telepon')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <div class="d-flex mt-3 justify-content-between">
                <?= Html::a(' Tutup', ['index'], [
                    'class' => 'btn btn-secondary',
                    'type' => 'button'
                ]) ?>
                <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>