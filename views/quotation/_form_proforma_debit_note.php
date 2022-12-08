<?php


/* @var $this View */

/* @var $model ProformaDebitNote|string|ActiveRecord */

use app\models\ProformaDebitNote;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;
use yii\db\ActiveRecord;
use yii\web\View;

?>

<div class="proforma-debit-note-form">
   <?php $form = ActiveForm::begin() ?>

   <?= $form->field($model, 'tanggal')->widget(DateControl::class, [
      'type' => DateControl::FORMAT_DATE
   ]) ?>

   <?= $form->field($model, 'pph_23_percent')->textInput([
      'type' => 'number'
   ]) ?>

    <div class="d-flex justify-content-between">
       <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
       <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
    </div>

   <?php ActiveForm::end() ?>
</div>