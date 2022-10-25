<?php

/* @var $this yii\web\View */
/* @var $model app\models\Barang */
/* @var $modelsDetail app\models\BarangSatuan */

use yii\helpers\Html;

$this->title = 'Update Barang: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Barang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>


</div>