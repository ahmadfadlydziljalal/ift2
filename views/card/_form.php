<?php

use app\models\CardType;
use app\models\MataUang;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Card */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="card-form">

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

            <?= $form->field($model, 'nama')->textInput([
                'maxlength' => true,
                'autofocus' => 'autofocus'
            ]) ?>

            <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'cardBelongsTypesForm')->widget(Select2::class, [
                'data' => CardType::find()->map(),
                'options' => [
                    'multiple' => true
                ]]);
            ?>

            <?= $form->field($model, 'alamat')->textarea(['rows' => 4]) ?>

            <?= $form->field($model, 'npwp')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'mata_uang_id')->dropDownList(MataUang::find()->map()) ?>


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