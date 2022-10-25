<?php

use app\models\User;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\search\SessionSearch $model */
/** @var ActiveForm $form */
?>

<div class="session-search">

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

    <?= $form->field($model, 'id',) ?>

    <?php $form->field($model, 'expire') ?>

    <?php $form->field($model, 'data') ?>

    <?= $form->field($model, 'user_id')->widget(Select2::class, [
        'data' => User::find()->map(),
        'options' => [
            'prompt' => '= Select an user ='
        ],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>

    <?php $form->field($model, 'last_write') ?>

    <div class="col mb-3">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>