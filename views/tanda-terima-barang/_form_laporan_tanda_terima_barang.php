<?php


/* @var $this View */
/* @see \app\controllers\TandaTerimaBarangController::actionLaporanIncoming() */

/* @var $model LaporanIncomingTandaTerimaBarang */

use app\enums\TextLinkEnum;
use app\models\form\LaporanIncomingTandaTerimaBarang;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\web\View;


$this->title = 'Laporan Incoming';
$this->params['breadcrumbs'][] = ['label' => 'Tanda Terima Barang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="tanda-terima-barang-laporan">

    <h1><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'tanggal')
        ->widget(DatePicker::class)
    ?>

    <?= Html::submitButton(TextLinkEnum::SEARCH->value, [
        'class' => 'btn btn-primary'
    ]) ?>

    <?php ActiveForm::end() ?>
</div>