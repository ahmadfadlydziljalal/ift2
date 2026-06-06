<?php

/**/

/* @var $this View */
/* @var $withBreadcrumb bool */

/* @see \app\controllers\SiteController::actionAbout() */

use yii\bootstrap5\Html;
use yii\web\View;

if (!$this->title) {
    $this->title = 'Tentang Web';

}

if ($withBreadcrumb) {
    $this->params['breadcrumbs'][] = $this->title;
}

?>

<div class="site-about">

    <div class="d-flex flex-column flex-nowrap">


        <div class="d-flex flex-column text-justify" style="gap: 1.5rem">
            <?= Yii::$app->settings->get('site.description') ?>
        </div>


        <div class="d-flex justify-content-between align-items-center py-2">
            <div class="d-flex flex-column">
                <span class="text-muted">Dibuat dan di maintenance oleh:</span>
                <span><?= Yii::$app->settings->get('site.maintainer') !== null ?
                        Yii::$app->settings->get('site.maintainer') :
                        Yii::$app->params['maintainer']
                    ?>
                </span>
            </div>

            <div class="px-3">
                <?php echo Html::img(Yii::getAlias('@web') . '/images/undraw_feeling_proud_qne1.svg', [
                    'class' => 'img-fluid',
                    'style' => [
                        'transform' => 'scaleX(-1)',
                        'width'     => '8rem',
                        'height'    => 'auto'
                    ]
                ]) ?>
            </div>

        </div>
    </div>
</div>