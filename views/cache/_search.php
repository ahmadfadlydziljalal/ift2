<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\search\CacheSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cache-search">

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

    <?= $form->field($model, 'expire') ?>

    <?= $form->field($model, 'data') ?>

    <div class="mb-3 col-auto">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>