<?php

use app\models\Card;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CardOwnEquipment */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="card-own-equipment-form">

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
           <?= $form->field($model, 'card_id')->widget(Select2::class, [
              'data' => Card::find()->map(Card::GET_ONLY_CUSTOMER),
              'options' => [
                 'placeholder' => 'Pilih sebuah card bertipe customer'
              ]
           ]) ?>
           <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'lokasi')->textarea(['rows' => 6]) ?>
           <?= $form->field($model, 'tanggal_produk')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
           <?= $form->field($model, 'serial_number')->textInput(['maxlength' => true]) ?>

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