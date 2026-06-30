<?php

use app\models\Barang;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\View;

/* @var $this View */
/* @var $barang Barang|null */
/* @var $path bool|int */
/* @var $model app\models\form\PrintStockMultipleStickerForm */
/* @var $width int */
/* @var $height int */
/* @var $orientation null|string */
?>

<?php if ($orientation == 'P') : ?>
    <!-- Height dan weight nya harus ditukar -->
<div style="position: absolute; left: 0; bottom: 0; rotate: -90; width: <?= $height - 2 ?>mm; height: <?= $width - 2 ?>mm; ">
    <?php endif; ?>
    <!-- Content -->
    <div style="width: 100%; margin:0">
        <div style=" float: left; width: 48%">
            <?= Html::img($path) ?>
        </div>
        <div style="float: right; text-align: right;  width: 50%">
            <div style="margin-bottom: 1em">
                <?php echo Html::img(Yii::getAlias('@webroot/images/logo.png'), ['width' => '1.5cm']) ?>
            </div>
            <span style="font-size: .60em;"><?= $barang->part_number ?> | <?= $barang->ift_number ?> | <?= $barang->id ?> </span><br/>
            <span style="font-size: .65em;"><?= StringHelper::truncate($barang->nama, 36) ?></span><br/>
            <span style="font-size: .5em;"><?= Yii::$app->formatter->asDatetime(date('Y-m-d H:i:s')) ?> <?= $orientation ?></span>
        </div>
        <div style="clear: both"></div>
    </div>

    <!-- Footer  -->
    <div style="width: 100%; margin:1em 0 0 0">
        <div style="float: left; text-align: left;  width: 19%">

        </div>
        <div style="float: right; text-align: right;  width: 80%">
            <barcode code=" <?= $barang->id ?>" type="C128B" height="0.5" text="1"></barcode>
        </div>
        <div style="clear: both"></div>
    </div>
    <?php if ($orientation == 'P') : ?>
</div>
<?php endif; ?>




