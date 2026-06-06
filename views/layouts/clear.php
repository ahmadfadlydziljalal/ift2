<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\ThemeAsset;
use yii\bootstrap5\Html;

ThemeAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);


?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body class="d-flex flex-column min-vh-100 <?= Yii::$app->params['theme'] ?>">

    <?php $this->beginBody() ?>
    <!-- Render content -->
    <main class="main">
        <?= $content ?>
    </main>
    <?php $this->endBody() ?>

    </body>

    </html>
<?php $this->endPage() ?>