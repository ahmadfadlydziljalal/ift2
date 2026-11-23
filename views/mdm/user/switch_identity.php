<?php

use app\models\form\UserSwitchIdentityForm;
use app\models\User;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $model UserSwitchIdentityForm */

?>

<div class="user-form">
    <?php $form = ActiveForm::begin([]) ?>

    <?= $form->field($model, 'userId')->label('User ID')->widget(Select2::class, [
        'data' => User::find()->map()
    ]) ?>

    <?= Html::submitButton('Login As', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>
