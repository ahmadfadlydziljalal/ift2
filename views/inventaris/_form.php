<?php

use app\models\Card;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Inventaris */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $mrdp array */
?>

<div class="inventaris-form">

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

   <?= $form->field($model, 'material_requisition_detail_penawaran_id')->dropDownList($mrdp) ?>
   <?= $form->field($model, 'location_id')->dropDownList(Card::find()->map(Card::GET_ONLY_WAREHOUSE)) ?>
   <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>

    <div class="d-flex mt-3 justify-content-between">
       <?= Html::a(' Tutup', ['index'], [
          'class' => 'btn btn-secondary',
          'type' => 'button'
       ]) ?>
       <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>

    </div>


   <?php ActiveForm::end(); ?>

</div>