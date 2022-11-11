<?php

/* @var $this yii\web\View */
/* @var $model app\models\TandaTerimaBarang */
/* @var $modelsDetail app\models\MaterialRequisitionDetailPenawaran */
/* @var $modelsDetailDetail app\models\TandaTerimaBarangDetail */

use yii\helpers\Html;
$this->title = 'Update Tanda Terima Barang: ' . $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Tanda Terima Barang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tanda-terima-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
        'modelsDetailDetail' => $modelsDetailDetail,
    ]) ?>

</div>