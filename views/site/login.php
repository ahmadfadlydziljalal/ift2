<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @see \app\controllers\SiteController::actionLogin() */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$title = (!Yii::$app->settings->get('site.name')
    ? Yii::$app->name : Yii::$app->settings->get('site.name'));
$this->title = $title . ' - Log In';

$backgroundImage = Yii::$app->settings->get("site.background-image");

$this->registerCss(<<<CSS
.site-login-split {
    min-height: 100vh;
}

.site-login-panel {
    min-height: 100vh;
}

.site-login-visual {
    color: #fff;
    background-color: #102941;
    background-image:
        linear-gradient(160deg, rgba(11, 22, 36, 0.2), rgba(11, 22, 36, 0.78)),
        url('$backgroundImage'),
        radial-gradient(circle at 20% 20%, rgba(255, 161, 81, 0.35), transparent 35%),
        linear-gradient(135deg, #1f4e79, #102941 45%, #0b1624 100%);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.site-login-visual::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: linear-gradient(rgba(255,255,255,0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.08) 1px, transparent 1px);
    background-size: 56px 56px;
    opacity: .25;
    pointer-events: none;
}

.site-login-visual-content,
.site-login-form-wrap {
    position: relative;
    z-index: 1;
}

.site-login-dot {
    width: 10px;
    height: 10px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .45);
}

.site-login-dot.is-active {
    width: 32px;
    background: #fff;
}

/*.site-login-form-panel {*/
/*    background: #f7f9fc;*/
/*}*/

.site-login-form-wrap {
    width: 100%;
    max-width: 460px;
}

.site-login-form-wrap .form-control {
    border-radius: .65rem;
    min-height: 46px;
}

.site-login-form-wrap .form-check-input {
    margin-top: .2rem;
}

.site-login-form-wrap .btn-login {
    border-radius: .7rem;
    min-height: 46px;
    font-weight: 600;
}
CSS
);

?>

<section class="container-fluid p-0 site-login-split">
    <div class="row g-0 min-vh-100">

        <!-- Panel Motto -->
        <div class="d-none d-md-flex col-md-6 col-xl-7 site-login-panel site-login-visual position-relative align-items-end">
            <div class="site-login-visual-content w-100 p-4 p-md-5">
                <div class="d-flex align-items-center gap-2 mb-4">
                    <span class="badge rounded-pill text-bg-light px-3 py-2">Part of RayaKreasi</span>
                    <!--<span class="fw-semibold fs-5">
                        <?php /*echo Yii::$app->settings->get('site.maintainer') */ ?>
                    </span>-->
                </div>

                <h1 class="display-2 fw-semibold mb-2"><?= Yii::$app->settings->get('site.slogan') ?></h1>
                <p class="mb-4 fw-bold text-white">Kelola kebutuhan bisnis Anda dalam satu dashboard yang cepat dan
                    modern.</p>

                <div class="d-flex align-items-center gap-2">
                    <span class="site-login-dot is-active"></span>
                    <span class="site-login-dot"></span>
                    <span class="site-login-dot"></span>
                </div>
            </div>
        </div>

        <!-- Panel Login        -->
        <div class="col-12 col-md-6 col-xl-5 site-login-panel site-login-form-panel d-flex align-items-center justify-content-center p-4 p-lg-5">
            <div class="site-login-form-wrap">
                <div class="d-flex justify-content-end mb-4 gap-2">

                    <!--<span class="badge rounded-pill bg-dark px-4 py-2">Log In</span>-->
                    <!--|-->
                    <?= Html::a((Yii::$app->params['theme'] === 'dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>'),
                        ['/dark-light-toggle/index'],
                        [
                            'id'    => 'dark-light-link',
                            'style' => [
                                'font-size' => '1.5em',
                            ]
                        ]
                    ) ?>
                </div>

                <h1 class="fw-bold mb-2"><?= $title ?></h1>
                <p class="text-secondary mb-4">Sign in to your account</p>

                <?php $form = ActiveForm::begin([
                    'id'                     => 'login-form',
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'username')->textInput([
                    'autofocus'   => true,
                    'placeholder' => 'Gunakan akun SIHRD Anda ...',
                ]) ?>

                <?= $form->field($model, 'password')->passwordInput([
                    'placeholder' => 'Enter your password',
                ]) ?>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <?= $form->field($model, 'rememberMe', [
                        'options' => ['class' => 'mb-0'],
                    ])->checkbox() ?>

                </div>

                <div class="d-grid mb-4">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-login', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <p class="text-center small text-secondary mb-0">
                    Dibuat dan di maintenance oleh:<br/>
                    TMS, IT Jakarta. Divisi Software Development.<br/>
                    &copy; <?= date('Y') ?>
                </p>
            </div>
        </div>
    </div>
</section>
