<?php

/* @var $this yii\web\View */
/* @var $model app\models\InventarisLaporanPerbaikanMaster */
/* @var $modelsDetail app\models\InventarisLaporanPerbaikanDetail */

use yii\helpers\Html;
$this->title = 'Tambah Inventaris Laporan Perbaikan Master';
$this->params['breadcrumbs'][] = ['label' => 'Inventaris Laporan Perbaikan Master', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="inventaris-laporan-perbaikan-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>
</div>