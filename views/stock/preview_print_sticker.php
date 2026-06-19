<?php

use app\models\Barang;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\View;

/* @var $this View */
/* @var $model Barang|null */
/* @var $path bool|int */
?>


<div style="width: 100%; height: 100%;">
    <div style="float: left; width: 40%">
        <?= Html::img($path) ?>
    </div>
    <div style="float: right; text-align: right; font-size: .90em; width: 59%">
        <p><?= $model->part_number ?><br/><?= $model->ift_number ?></p>
    </div>
    <div style="clear: both"></div>
    <p style="font-size: .75em; margin-bottom: 0;margin-top: 4pt"><?= StringHelper::truncate($model->nama, 32) ?></p>
</div>
