<?php

use app\models\Barang;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\View;

/* @var $this View */
/* @var $model Barang|null */
/* @var $path bool|int */
?>

<div style="width: 100%;">
    <div style="float: left; text-align: left; width: 20%; margin-bottom: 1em; ">
        <?= Html::img(Yii::getAlias('@webroot/images/logo.png'), ['width' => '.5cm']) ?><br/>
        <span style="font-size: .25em">Indo Formosa Trading, PT</span>
    </div>
    <div style="float: right; text-align: right; width: 80%; margin-bottom: 1em">
        <barcode code="<?= $model->id ?>" type="C128B" height="0.5" text="1"></barcode>
    </div>
    <div style="clear: both"></div>
</div>

<div style="width: 100%;">
    <div style=" float: left; width: 30%">
        <?= Html::img($path) ?>
    </div>
    <div style="float: right; text-align: right;  width: 69%">
        <span style="font-size: .5em;"><?= $model->part_number ?> | <?= $model->ift_number ?> | <?= $model->id ?> </span><br/>
        <span style="font-size: .5em;"><?= StringHelper::truncate($model->nama, 48) ?></span><br/>
        <small style="font-size: .25em;"><?= Yii::$app->formatter->asDatetime(date('Y-m-d H:i:s')) ?></small>
    </div>
    <div style="clear: both"></div>
</div>

