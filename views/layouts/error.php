<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\ThemeAsset;
use yii\bootstrap5\Html;

ThemeAsset::register($this);

?>
<?php $this->beginPage() ?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Sharing Data among Views , for Meta Tag -->
       <?php
       if (isset($this->params['metaTags'])) {
          foreach ($this->params['metaTags'] as $keyTag => $elementTag) {
             $this->registerMetaTag($elementTag);
          }
       }
       ?>

       <?php $this->registerCsrfMetaTags() ?>

        <link rel="apple-touch-icon" sizes="180x180" href="/img/fav-icon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/img/fav-icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/img/fav-icon/favicon-16x16.png">
        <link rel="manifest" href="/img/fav-icon/site.webmanifest">

        <title><?= Html::encode($this->title) ?></title>

       <?php $this->head() ?>
    </head>

    <body class="d-flex flex-column h-100 align-items-center justify-content-center">
    <?php $this->beginBody() ?>
    <div class="content">
       <?= $content ?>
    </div>

    <div class="align-items-start">
       <?= Html::a('<i class="bi bi-arrow-left"></i> ' . Yii::$app->request->referrer,
          empty(Yii::$app->request->referrer) ?
             ['site/index'] :
             Yii::$app->request->referrer
          , ['class' => 'btn btn-primary'])
       ?>
       <?= Html::a('<i class="bi bi-house"></i>' . ' Kembali ke homepage', ['/site/index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php $this->endBody() ?>
    </body>

    </html>
<?php $this->endPage() ?>