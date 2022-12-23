<?php

/* @var $this yii\web\View */
/* @var $model app\models\InventarisLaporanPerbaikanMaster */
/* @var $modelsDetail app\models\InventarisLaporanPerbaikanDetail */

use yii\helpers\Html;

$this->title = 'Update Inventaris Laporan Perbaikan Master: ' . $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Inventaris Laporan Perbaikan Master', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inventaris-laporan-perbaikan-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>

</div>