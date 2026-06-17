<?php

/* @var $this yii\web\View */

/* @var $model app\models\Barang|null */

/* @var $stock Stock */

use app\models\Stock;
use app\widgets\stock\StockItem;
use Da\QrCode\QrCode;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="stock-expand">

    <div>
        <?php
        /** @see \app\controllers\SiteController::actionScan() */
        $qrCode = (new QrCode(Url::to(['/scan', 'object' => 'stock', 'params' => ['id' => $model->id]], true)))
            ->setSize(125)
            ->setMargin(5);


        ?>

        <?= StockItem::widget([
            'model'          => $stock,
            'additionalView' => Html::img($qrCode->writeDataUri())
        ]) ?>
    </div>


</div>
