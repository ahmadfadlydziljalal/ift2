<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\PrintAsset;
use yii\bootstrap5\Html;

PrintAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

$settings = Yii::$app->settings;
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>

    <?php $this->beginBody() ?>

    <div id="header">
        <table>
            <tr>
                <td>
                    <?= Html::img(Yii::getAlias('@web') . '/images/logo.png', [
                        'width' => '128px',
                        'height' => 'auto'
                    ]) ?>
                </td>
                <td>
                    <h3 style="margin: 0; padding: 0">
                        <?= $settings->get('site.companyClient') ?>
                    </h3>
                    <p style="margin: 0; padding: 0; font-size: 10pt">
                        <?= $settings->get('site.alamat') ?><br/>
                        Telp: <?= $settings->get('site.telepon') ?>,
                        Email: <?php echo $settings->get('site.email') ?>
                    </p>
                </td>
            </tr>
        </table>
    </div>

    <div id="content">
        <?= $this->render('_content', ['content' => $content]) ?>
    </div>

    <?php $this->endBody() ?>

    </body>

    </html>
<?php $this->endPage() ?>