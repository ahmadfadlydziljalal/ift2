<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Contact';

if($withBreadcrumb){
    $this->params['breadcrumbs'][] = $this->title;

}
?>
<div class="site-contact d-flex flex-column gap-2 px-0 mx-5 mx-sm-5 mx-md-3 mx-lg-0 align-items-center">

    <h1 class="align-self-start"><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
        <?php $this->params['breadcrumbs'] = [] ?>
        <div class="contact-form-submitted w-100">

            <div class="alert alert-success">
                Thank you for contacting us. We will respond to you as soon as possible.
            </div>
            <p>
                <?= Html::a('Kembali ke beranda', ['/'], ['class' => 'btn btn-outline-primary']) ?>
            </p>

        </div>

    <?php else: ?>

        <div class="contact-section d-flex flex-row gap-5">

            <div class="contact-form">
                <p class="text-justify">
                    Jika Anda memiliki pertanyaan bisnis atau pertanyaan lain,
                    Silakan isi formulir berikut untuk menghubungi kami.
                    Terima kasih.
                </p>

                <?php $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'enableClientValidation' => true,
                    'layout' => ActiveForm::LAYOUT_FLOATING,
                ]); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'subject') ?>
                <?= $form->field($model, 'body')
                    ->textarea([
                        'rows' => 6,
                        'style' => [
                            'min-height' => '12rem'
                        ]
                    ]) ?>

                <div class="py-3 px-0">
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                        'template' => '
                    <div class="d-flex justify-content-between">
                        <div style="width: 80%">
                         {image}
                        </div>
                        {input}
                    </div>
                ',
                    ])->label(false) ?>
                </div>

                <div class="form-group d-flex justify-content-between">
                    <?= Html::a('Beranda', ['/'], ['class' => 'btn btn-outline-primary']) ?>
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>

            <?php if(!Yii::$app->user->isGuest) : ?>
                <div class="image align-self-center">
                    <?= Html::img(Yii::getAlias('@web') . '/images/undraw_newsletter_re_wrob.svg', [
                        'class' => 'img-fluid',
                        'style' => [
                            'transform' => 'scaleX(-1)'
                        ]
                    ]) ?>
                </div>
            <?php endif ?>

        </div>

    <?php endif; ?>

</div>