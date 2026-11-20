<?php

use kartik\base\BootstrapInterface;
use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */
/* @var $modelsDetail app\models\BarangSatuan */
/* @var $form ActiveForm */

?>

<div class="barang-form">

    <?php $form = ActiveForm::begin([
            'id'         => 'dynamic-form',
            'type'       => ActiveForm::TYPE_HORIZONTAL,
            'formConfig' => [
                    'deviceSize' => BootstrapInterface::SIZE_LARGE,
                    'labelSpan'  => 4,
            ],
    ]); ?>

    <?= $this->render('_form_master', [
            'form'  => $form,
            'model' => $model
    ]) ?>

    <?= $this->render('_form_detail', [
            'form'         => $form,
            'modelsDetail' => $modelsDetail
    ]) ?>

    <div class="d-flex justify-content-between">
        <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>