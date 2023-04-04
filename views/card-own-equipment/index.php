<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CardOwnEquipmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\CardOwnEquipmentController::actionIndex() */

$this->title = 'Card Own Equipment';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="card-own-equipment-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
           <?= Html::a('Refresh', ['index'], ['class' => 'btn btn-primary']) ?>
           <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

   <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => require(__DIR__ . '/_columns.php'),
   ]);
   ?>

</div>