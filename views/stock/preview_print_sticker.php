<?php

use app\models\Barang;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\View;

/* @var $this View */
/* @var $model Barang|null */
/* @var $path bool|int */
?>

<div style="width: 100%; height: 100%; border: 1px solid #000; padding: 1em;">
    <div style="width: 100%; margin-bottom: 1em;">
        <div style="float: left; text-align: left; width: 30%;">
            <?= Html::img(Yii::getAlias('@webroot/images/logo.png'), ['width' => '2cm']) ?><br/>
        </div>
        <div style="float: right; text-align: right; width: 69%;">
            <span style="font-size: 1em;">Indo Formosa Trading, PT</span>
        </div>
        <div style="clear: both"></div>
    </div>

    <div style="width: 100%; margin:0">
        <div style=" float: left; width: 30%">
            <?= Html::img($path) ?>
            <small style="font-size: .5em;"><?= Yii::$app->formatter->asDatetime(date('Y-m-d H:i:s')) ?></small>
        </div>
        <div style="float: right; text-align: right;  width: 69%">
            <div style="margin-bottom: .5em">
                <barcode code="<?= $model->id ?>" type="C128B" height="0.5" text="1"></barcode>
            </div>

            <span style="font-size: 1em;"><?= $model->part_number ?> | <?= $model->ift_number ?> | <?= $model->id ?> </span><br/>
            <span style="font-size: 1em;"><?= StringHelper::truncate($model->nama, 42) ?></span><br/>
        </div>
        <div style="clear: both"></div>
    </div>
</div>


