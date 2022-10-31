<?php

/* @var $this yii\web\View */
/* @var $model app\models\MaterialRequisition */
/* @var $modelsDetail app\models\MaterialRequisitionDetail */

use yii\helpers\Html;

$this->title = 'Update Material Requisition: ' . $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Material Requisition', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="material-requisition-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>

</div>