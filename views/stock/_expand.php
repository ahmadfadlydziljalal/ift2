<?php

/* @var $this yii\web\View */

/* @var $model app\models\Barang|null */

/* @var $stock Stock */

use app\components\QrCodeStockGenerator;
use app\models\form\PrintStockMultipleStickerForm;
use app\models\Stock;
use app\widgets\stock\StockItem;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="stock-expand">
    <?php
    
    $additionalView = '';
    foreach (PrintStockMultipleStickerForm::getFormatOptions(false) as $label => $options) {
        $additionalView .= Html::a('Print ' . $label, ['print-sticker', 'id' => $model->id, 'width' => $options['width'], 'height' => $options['height']], [
            'class'  => 'btn btn-success mb-2 me-2 mr-2',
            'target' => '_blank',
            'rel'    => 'noopener noreferrer'
        ]);
    }

    echo StockItem::widget([
        'model'          => $stock,
        'additionalView' => Html::tag('div',
                Html::img(
                    (new QrCodeStockGenerator([
                        'text' => Url::to(['/scan', 'object' => 'stock', 'params' => ['id' => $model->id]], true),
                    ]))->toWriteDataUri()
                    ,
                    [
                        'class' => 'img-fluid'
                    ]
                ), [
                    'class' => 'd-flex w-100 mb-4'
                ]
            ) . ' ' . $additionalView,
    ]) ?>
</div>
