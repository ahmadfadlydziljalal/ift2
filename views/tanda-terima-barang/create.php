<?php

/* @var $this yii\web\View */
/* @var $model app\models\TandaTerimaBarang */

/* @var $modelsDetail app\models\TandaTerimaBarangDetail */

use yii\helpers\Html;

$this->title = 'Tambah Tanda Terima Barang';
$this->params['breadcrumbs'][] = ['label' => 'Tanda Terima Barang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tanda-terima-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>

</div>