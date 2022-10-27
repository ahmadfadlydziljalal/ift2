<?php

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */
/* @var $modelsDetail app\models\PurchaseOrderDetail */

use yii\helpers\Html;

$this->title = 'Update Purchase Order: ' . $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nomor, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="purchase-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetail' => $modelsDetail,
    ]) ?>

</div>