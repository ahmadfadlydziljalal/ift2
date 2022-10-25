<?php

use app\models\form\ChangePassword;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model ChangePassword */
/* @see \app\controllers\SiteController::actionChangePassword() */
$this->title = "Ganti Password";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-change-password">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-5">

            <?php $form = ActiveForm::begin([
                'layout' => ActiveForm::LAYOUT_FLOATING,
                'enableClientValidation' => false
            ]); ?>

            <?= $form->field($model, 'new_password')->passwordInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'repeat_password')->passwordInput() ?>

            <?= Html::submitButton('Ganti', [
                'class' => 'btn btn-primary ml-auto mt-3',
            ]) ?>

            <div class="mt-3">
                <p class="text-muted mt-4 text-justify">
                    Setelah Anda berhasil mengganti Password, Anda Akan otomatis logout.<br/>
                    Pastikan anda mengingat password Anda yang baru.
                </p>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>