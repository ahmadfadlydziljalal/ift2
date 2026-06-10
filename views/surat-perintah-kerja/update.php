<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SuratPerintahKerja */
/* @see app\controllers\SuratPerintahKerjaController::actionUpdate() */

$this->title = 'Update Surat Perintah Kerja: ' . $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Surat Perintah Kerja', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="surat-perintah-kerja-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>