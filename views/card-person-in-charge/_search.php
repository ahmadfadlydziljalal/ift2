<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\CardPersonInChargeSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="card-person-in-charge-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'card_id') ?>

    <?= $form->field($model, 'nama') ?>

    <?= $form->field($model, 'telepon') ?>

    <?= $form->field($model, 'email') ?>

    <div class="d-flex mt-3 justify-content-between">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>