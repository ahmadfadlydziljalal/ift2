<?php

use app\widgets\stock\StockItem;


/* @var $data app\models\Stock */
/* @var $this yii\web\View */
/* @see \app\controllers\SiteController::actionScan() */

?>

<div class="stock-scan-view">
    <?= StockItem::widget(['model' => $data]) ?>
</div>
