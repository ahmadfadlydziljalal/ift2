<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\search\LogSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'layout' => ActiveForm::LAYOUT_INLINE,
        'options' => [
            'class' => 'row'
        ],
        'fieldConfig' => [
            'options' => [
                'class' => ' mb-3 col-auto'
            ]
        ]
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'level') ?>

    <?= $form->field($model, 'category') ?>
    
    <?= $form->field($model, 'prefix') ?>

    <?php // echo $form->field($model, 'message') ?>

    <div class="mb-3 col-auto">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>