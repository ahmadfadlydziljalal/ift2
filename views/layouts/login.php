<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\LoginAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

LoginAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100 w-100 m-0 p-0">

    <head>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body class="d-flex flex-column align-items-center justify-content-center min-vh-100 m-0 p-0 <?= Yii::$app->params['theme'] ?>">
    <?php $this->beginBody() ?>

    <main class="mt-auto">
        <?php if (!empty($this->params['breadcrumbs'])) : ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </main>


    <footer class="footer mt-auto text-muted w-100 px-5 py-3">
        <?php echo $this->render('_footer') ?>
    </footer>


    <?php $this->endBody() ?>
    </body>

    </html>
<?php $this->endPage() ?>