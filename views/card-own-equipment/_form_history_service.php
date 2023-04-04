<?php

use app\models\CardOwnEquipmentHistory;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;
use yii\db\ActiveRecord;
use yii\web\View;


/* @var $this View */
/* @var $model CardOwnEquipmentHistory|string|ActiveRecord */
?>

<div class="card-own-equipment-form">
   <?php $form = ActiveForm::begin([
      'type' => ActiveForm::TYPE_HORIZONTAL,
      'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
   ]) ?>

    <div class="row">
        <div class="col-sm-12 col-md-9">

            <div class="d-flex flex-column gap-3">

                <div class="card bg-transparent rounded shadow border-0">
                    <div class="card-body">
                        <div class="py-3 d-flex flex-row gap-5 align-items-center fw-bold">
                            <div style="min-width: 12rem"><i class="bi bi-wrench"></i> Service Aktual</div>
                            <div class="flex-grow-1 border border-3"></div>
                        </div>
                       <?= $form->field($model, 'tanggal_service_saat_ini')->widget(DateControl::class, [
                          'type' => DateControl::FORMAT_DATE
                       ]); ?>
                       <?= $form->field($model, 'hour_meter_saat_ini')->textInput([
                          'type' => 'number'
                       ]); ?>
                       <?= $form->field($model, 'kondisi_terakhir')->textarea([
                          'rows' => '6'
                       ]); ?>
                       <?= $form->field($model, 'service_terakhir')->textInput([
                          'type' => 'number'
                       ]) ?>
                    </div>
                </div>

                <div class="card bg-transparent rounded shadow border-0">
                    <div class="card-body">
                        <div class="py-3 d-flex flex-row gap-5 align-items-center fw-bold">
                            <div style="min-width: 12rem"><i class="bi bi-wrench-adjustable"></i> Service Selanjutnya
                            </div>
                            <div class="flex-grow-1 border border-3"></div>
                        </div>

                       <?= $form->field($model, 'service_selanjutnya')->textInput([
                          'type' => 'number'
                       ]) ?>
                       <?= $form->field($model, 'hour_meter_service_selanjutnya')->textInput([
                          'type' => 'number'
                       ]) ?>
                       <?= $form->field($model, 'tanggal_service_selanjutnya')->widget(DateControl::class, [
                          'type' => DateControl::FORMAT_DATE
                       ]); ?>
                    </div>
                </div>
                <div class="d-flex mt-3 justify-content-between">
                   <?= Html::a(' Tutup', ['index'], [
                      'class' => 'btn btn-secondary',
                      'type' => 'button'
                   ]) ?>
                   <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>


        </div>
    </div>


   <?php ActiveForm::end(); ?>
</div>