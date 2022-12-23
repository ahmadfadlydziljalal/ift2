<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\InventarisSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="inventaris-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'material_requisition_detail_penawaran_id') ?>

    <?= $form->field($model, 'kode_inventaris') ?>

    <?= $form->field($model, 'location_id') ?>

    <?= $form->field($model, 'quantity') ?>

    <div class="d-flex mt-3 justify-content-between">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>