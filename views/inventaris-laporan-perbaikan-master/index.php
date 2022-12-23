<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InventarisLaporanPerbaikanMasterSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Laporan Perbaikan Inventaris';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="inventaris-laporan-perbaikan-master-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
           <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

   <?php
   echo GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => require(__DIR__ . '/_columns.php'),
   ]);
   ?>

</div>