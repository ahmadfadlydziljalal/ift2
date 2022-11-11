<?php


/* @var $this View */
/* @var $modelMaterialRequisition MaterialRequisition */
/* @var $modelMaterialRequisitionDetail MaterialRequisitionDetail|null */
/* @see \app\controllers\MaterialRequisitionController::actionUpdatePenawaran() */

/* @var $modelsDetail MaterialRequisitionDetailPenawaran[] */

use app\models\MaterialRequisition;
use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use yii\bootstrap5\Html;
use yii\web\View;

$this->title = 'Update Penawaran';
$this->params['breadcrumbs'][] = ['label' => 'Material Requisition', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelMaterialRequisition->nomor, 'url' => ['view', 'id' => $modelMaterialRequisition->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="material-requisition-update">
    <h1><?= $this->title ?></h1>
    <div>
        <?= Html::tag('span', $modelMaterialRequisition->nomor, ['class' => 'badge bg-success']) ?>
        <?= Html::tag('span', $modelMaterialRequisitionDetail->barang->nama, ['class' => 'badge bg-info']) ?>
        <?= Html::tag('span', $modelMaterialRequisitionDetail->quantity, ['class' => 'badge bg-warning']) ?>
        <?= Html::tag('span', $modelMaterialRequisitionDetail->satuan->nama, ['class' => 'badge bg-dark']) ?>

    </div>


    <?= $this->render('_form_penawaran', [
        'modelsDetail' => $modelsDetail,
        'modelMaterialRequisition' => $modelMaterialRequisition,
        'modelMaterialRequisitionDetail' => $modelMaterialRequisitionDetail,
    ]) ?>

</div>