<?php

use yii\bootstrap5\Html; ?>

<div class="row">
    <div class="col-md-6 text-center text-md-start">

        &copy; <?=
        empty(Yii::$app->settings->get('site.companyClient')) ?
            Yii::$app->params['companyName'] :
            Yii::$app->settings->get('site.companyClient')
        ?>, <?= date('Y') ?>

    </div>
    <div class="col-md-6 text-center text-md-end">
        <?php
        echo Html::a(

            (empty(Yii::$app->settings->get('site.maintainerCompany'))
                ? Yii::$app->params['myOwnCompany'] :
                Yii::$app->settings->get('site.maintainerCompany')
            )
            , "https://rayakreasi.xyz/", [
            'class' => 'text-primary text-decoration-none'
        ]);
        ?>
        |
        <?= Html::a((Yii::$app->params['theme'] === 'dark' ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon"></i>'),
            ['/dark-light-toggle/index'],
            [
                'id' => 'dark-light-link',
            ]
        ) ?>

        <?php
        echo ' | ' . Yii::$app->params['appVersion'] . '-' . ucfirst(Yii::$app->params['env'])
        ?>
    </div>
</div>