<?php
/** @var string $content */

/** @var $this View */

use yii\web\View;

?>

<?php $this->beginContent('@app/views/layouts/clear.php') ?>
<div class="scan-layout d-flex align-items-center justify-content-center min-vh-100">
    <div class="w-100" style="max-width: 960px;">
        <?= $content ?>
    </div>
</div>
<?php $this->endContent(); ?>

