<?php

/* @var $this yii\web\View */
/* @var $model app\models\Rekening */
/* @var $modelsDetail app\models\RekeningDetail */

use yii\helpers\Html;

$this->title = 'Update Rekening: ' . $model->atas_nama;
$this->params['breadcrumbs'][] = ['label' => 'Rekening', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->atas_nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rekening-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>

</div>