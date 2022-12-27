<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\HistoryLokasiBarang */
/* @see app\controllers\HistoryLokasiBarangController::actionUpdate() */

$this->title = 'Update History Lokasi Barang: ' . $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'History Lokasi Barang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="history-lokasi-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>