<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Inventaris */
/* @var $mrdp array */
/* @see app\controllers\InventarisController::actionUpdate() */

$this->title = 'Update Inventaris: ' . $model->kode_inventaris;
$this->params['breadcrumbs'][] = ['label' => 'Inventaris', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_inventaris, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="inventaris-update">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form', [
      'model' => $model,
      'mrdp' => $mrdp,
   ]) ?>
</div>