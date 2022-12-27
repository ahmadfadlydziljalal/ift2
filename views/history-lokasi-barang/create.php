<?php
/* @var $this yii\web\View */
/* @var $model app\models\HistoryLokasiBarang */
/* @see app\controllers\HistoryLokasiBarangController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah History Lokasi Barang';
$this->params['breadcrumbs'][] = ['label' => 'History Lokasi Barang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="history-lokasi-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>