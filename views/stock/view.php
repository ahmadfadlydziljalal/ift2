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