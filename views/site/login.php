<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$title = (!Yii::$app->settings->get('site.name')
    ? Yii::$app->name : Yii::$app->settings->get('site.name'));
$this->title = $title . ' - Log In';

?>

<div class="site-login d-flex flex-row gap-5 px-0 px-md-5 px-lg-5 align-items-top">
    <div class="login-section" style="min-width: 20rem">
        <h1 class="text-center d-sm-block d-md-none d-lg-none mb-3 mb-md-0 mb-lg-0">
            <?= Yii::$app->settings->get('site.icon') ?>
            <?= Html::encode($title) ?>
        </h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'enableClientValidation' => false,
            'layout' => ActiveForm::LAYOUT_FLOATING,
        ]); ?>
        <div class="card rounded-2 shadow">
            <div class="card-body">

                <?= $form->field($model, 'username')->textInput([
                    'autofocus' => true,
                ]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div class="form-group d-grid gap-2 my-3 ">
                    <?= Html::submitButton('Log In', ['class' => 'btn btn-lg btn-primary', 'name' => 'login-button']) ?>
                </div>

                <div class="border-top py-2">
                    <p class="text-muted text-center">Problem with your account?</p>
                    <div class="form-group d-grid gap-2 mt-3">
                        <?= Html::a('<i class="bi bi-envelope-heart"></i> Email Admin ', ['site/contact'], ['class' => 'btn btn-lg btn-outline-success']) ?>
                    </div>


                </div>

            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
    <div class="about-section d-none d-md-block d-lg-block" style="max-width: 32rem">
        <?= $this->render('about', [
            'withBreadcrumb' => false
        ]) ?>
    </div>
</div>