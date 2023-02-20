<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */
/* @var $modelsDetail app\models\BarangSatuan */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="barang-form">

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
   
   <?= $this->render('_form_master', [
      'form' => $form,
      'model' => $model
   ]) ?>

   <?= $this->render('_form_detail', [
      'form' => $form,
      'modelsDetail' => $modelsDetail
   ]) ?>

    <div class="d-flex justify-content-between">
       <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
       <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
    </div>

   <?php ActiveForm::end(); ?>

</div>