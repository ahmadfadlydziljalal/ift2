<?php

/* @var $this yii\web\View */

/* @var $model app\models\Barang|null */

/* @var $stock Stock */

use app\components\QrCodeStockGenerator;
use app\models\Stock;
use app\widgets\stock\StockItem;
use Da\QrCode\QrCode;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="stock-expand">
    <?php
    /** @see \app\controllers\SiteController::actionScan() */

    $url = Url::to(['/scan', 'object' => 'stock', 'params' => ['id' => $model->id]], true);
    $qrCode = (new QrCode($url))
        ->setSize(125)
        ->setMargin(5);
    ?>
    <?php
    $qrCodeImage = Html::tag(
        'div',
        Html::tag(
            'div',
            Html::img(
                (new QrCodeStockGenerator([
                    'text' => Url::to(['/scan', 'object' => 'stock', 'params' => ['id' => $model->id]], true),
                ]))->toWriteDataUri()
                ,
                [
                    'class' => 'img-fluid'
                ]
            )
        ) .
        Html::a('Print', ['print-sticker', 'id' => $model->id], [
            'class'  => 'btn btn-success',
            'target' => '_blank',
            'rel'    => 'noopener noreferrer'
        ])
        ,
        [
            'class' => 'd-flex flex-column  gap-2'
        ]
    );
    Html::img($qrCode->writeDataUri(), ['class' => 'img-fluid']);
    ?>
    <?= StockItem::widget([
        'model'          => $stock,
        'additionalView' => $qrCodeImage,
    ]) ?>
</div>
