<?php
/* @var $this yii\web\View */
/* @var $model app\models\Inventaris */
/* @var $mrdp array */

/* @see app\controllers\InventarisController::actionCreate() */

use yii\helpers\Html;

$this->title = 'Tambah Inventaris';
$this->params['breadcrumbs'][] = ['label' => 'Inventaris', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="inventaris-create">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= $this->render('_form', [
      'model' => $model,
      'mrdp' => $mrdp,
   ]) ?>
</div>