<?php


/* @var $this View */
/* @var $modelMaterialRequisition MaterialRequisition|null */
/* @var $modelsDetail MaterialRequisitionDetailPenawaran[] */
/* @var $modelMaterialRequisitionDetail MaterialRequisitionDetail |null */

/* @see \app\controllers\MaterialRequisitionController::actionCreatePenawaran() */

use app\models\MaterialRequisition;
use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Tambah Penawaran';
$this->params['breadcrumbs'][] = ['label' => 'Material Requisition', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelMaterialRequisition->nomor, 'url' => ['view', 'id' => $modelMaterialRequisition->id]];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="material-requisition-create">
    <h1><?= $this->title ?></h1>

    <div>
        <?= Html::tag('span', $modelMaterialRequisition->nomor, ['class' => 'badge bg-success']) ?>
        <?= Html::tag('span', $modelMaterialRequisitionDetail->barang->nama, ['class' => 'badge bg-info']) ?>
    </div>

    <?= $this->render('_form_penawaran', [
        'modelsDetail' => $modelsDetail,
        'modelMaterialRequisition' => $modelMaterialRequisition,
    ]) ?>

</div>