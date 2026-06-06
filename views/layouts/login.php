<?php
/** @var string $content */

/** @var $this View */

use app\widgets\Alert;
use yii\web\View;

?>

<?php $this->beginContent('@app/views/layouts/clear.php') ?>
<?= Alert::widget() ?>
<?= $content ?>
<?php $this->endContent(); ?>

