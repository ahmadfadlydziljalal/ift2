<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\CardOwnEquipmentSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="card-own-equipment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'card_id') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'lokasi') ?>

    <?= $form->field($model, 'tanggal_produk') ?>

    <?php // echo $form->field($model, 'serial_number') ?>

    <div class="d-flex mt-3 justify-content-between">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>