<?php

/**
 * @var $content string
 * */

use app\widgets\Alert;
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
    echo Alert::widget();
} catch (Throwable $e) {
    echo $e->getMessage();
} ?>

<?= $content ?>