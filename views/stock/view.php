<?php

use app\models\search\StockPerBarangSearch;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $searchModel StockPerBarangSearch */
/* @var $dataProvider */

$this->title = $searchModel->barang->nama;
$this->params['breadcrumbs'][] = ['label' => 'Stock', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="stock-per-barang">

    <h1>Stock: <?= Html::encode($searchModel->barang->nama) ?></h1>

    <div class="d-flex flex-row gap-3 mb-2">
       <?= Html::tag('span', $searchModel->barang->part_number, ['class' => 'badge bg-primary']) ?>
       <?= Html::tag('span', $searchModel->barang->ift_number, ['class' => 'badge bg-primary']) ?>
       <?= Html::tag('span', $searchModel->barang->merk_part_number, ['class' => 'badge bg-primary']) ?>
    </div>

   <?php echo GridView::widget([
      'tableOptions' => [
         'class' => 'table table-gridview' // table-fixes-last-column
      ],
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => require __DIR__ . DIRECTORY_SEPARATOR . '_columns_view.php',
      'rowOptions' => [
         'class' => 'align-middle text-nowrap'
      ]
   ]); ?>


</div>