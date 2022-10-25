<?php



/* @var $this \yii\web\View */
/* @var $model \app\models\User|\yii\db\ActiveRecord */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

?>


<div class="user-form">

    <p>Please fill out the following fields to signup:</p>
    <?= Html::errorSummary($model)?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'new_password')->passwordInput() ?>
            <?= $form->field($model, 'repeat_password')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Create', ['class' => 'btn btn-primary', 'name' => 'create-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>