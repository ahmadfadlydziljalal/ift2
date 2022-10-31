<?php

/* @var $this yii\web\View */
/* @var $model app\models\MaterialRequisition */
/* @var $modelsDetail app\models\MaterialRequisitionDetail */

use yii\helpers\Html;
$this->title = 'Tambah Material Requisition';
$this->params['breadcrumbs'][] = ['label' => 'Material Requisition', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="material-requisition-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>
</div>