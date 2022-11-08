<?php

/**
 * @var $content string
 * */

use pa3py6aka\yii2\ModalAlert;
use yii\bootstrap5\Breadcrumbs;

if (!empty($this->params['breadcrumbs'])) : ?>
    <?php try {
        echo Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'],
            'options' => [
                'class' => 'mx-1 mb-3'
            ]
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    } ?>
<?php endif ?>

<?php try {
    echo ModalAlert::widget([
        'type' => ModalAlert::TYPE_BOOTSTRAP_5,
        'alertTypes' => [
            'error' => 'bg-danger text-white',
            'danger' => 'bg-danger text-white',
            'success' => 'bg-success text-white',
            'info' => 'bg-info text-white',
            'warning' => 'bg-warning'
        ],
        'popupView' => '/layouts/modals/bs5-modal'
    ]);
} catch (Throwable $e) {
    echo $e->getMessage();
} ?>

<?= $content ?>