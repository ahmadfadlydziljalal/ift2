<?php

use app\components\grid\ActionColumn;
use app\models\search\StockInPerBarangSearch;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $searchModel StockInPerBarangSearch */
/* @var $dataProvider */

$this->title = 'In';
$this->params['breadcrumbs'][] = ['label' => 'Stock', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="stock-per-barang">
    <h1>In Stock <?= Html::encode($searchModel->barang->nama) ?></h1>

   <?= GridView::widget([
      'tableOptions' => [
         'class' => 'table table-gridview table-fixes-last-column'
      ],
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
         [
            'class' => SerialColumn::class
         ],
         'partNumber',
         'kodeBarang',
         'namaBarang',
         'merk',
         'nomorTandaTerima',
         [
            'class' => DataColumn::class,
            'attribute' => 'tgl_tanda_terima',
            'format' => 'date',
            'contentOptions' => [
               'class' => 'text-end'
            ]
         ],
         [
            'class' => DataColumn::class,
            'attribute' => 'qty_terima',
            'contentOptions' => [
               'class' => 'text-end'
            ]
         ],
         [
            'class' => ActionColumn::class,
            'mergeHeader' => false,
            'template' => '{set-lokasi}',
            'buttons' => [
               'set-lokasi' => function ($url, $model, $key) {
                  return Html::a('Set Lokasi', ['stock/stock-in-set-lokasi', 'id' => $key], [
                     'class' => 'text-primary'
                  ]);
               }
            ],
         ]
      ]
   ]) ?>
</div>