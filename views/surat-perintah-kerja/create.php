<?php
/* @var $this yii\web\View */
/* @var $model app\models\SuratPerintahKerja */
/* @see app\controllers\SuratPerintahKerjaController::actionCreate() */

use yii\helpers\Html;
$this->title = 'Tambah Surat Perintah Kerja';
$this->params['breadcrumbs'][] = ['label' => 'Surat Perintah Kerja', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="surat-perintah-kerja-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>