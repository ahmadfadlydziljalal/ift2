<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\HistoryLokasiBarangSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="history-lokasi-barang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nomor') ?>

    <?= $form->field($model, 'card_id') ?>

    <?= $form->field($model, 'tanda_terima_barang_detail_id') ?>

    <?= $form->field($model, 'claim_petty_cash_nota_detail_id') ?>

    <?php // echo $form->field($model, 'quotation_delivery_receipt_detail_id') ?>

    <?php // echo $form->field($model, 'tipe_pergerakan_id') ?>

    <?php // echo $form->field($model, 'step') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'block') ?>

    <?php // echo $form->field($model, 'rak') ?>

    <?php // echo $form->field($model, 'tier') ?>

    <?php // echo $form->field($model, 'row') ?>

    <?php // echo $form->field($model, 'catatan') ?>

    <?php // echo $form->field($model, 'depend_id') ?>

    <div class="d-flex mt-3 justify-content-between">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>