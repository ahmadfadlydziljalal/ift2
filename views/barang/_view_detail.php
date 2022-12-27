<?php


/* @var $this View */

use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap5\Html;
use yii\data\ArrayDataProvider;
use yii\web\View;

?>

<div class="barang-view-detail">
    <h2>Barang Satuan</h2>
   <?php
   try {
      echo !empty($model->barangSatuans) ?
         GridView::widget([
            'dataProvider' => new ArrayDataProvider([
               'allModels' => $model->barangSatuans
            ]),
            'columns' => [
               [
                  'class' => SerialColumn::class
               ],
               [
                  'class' => '\yii\grid\DataColumn',
                  'attribute' => 'vendor_id',
                  'value' => 'vendor.nama'
               ],
               [
                  'class' => '\yii\grid\DataColumn',
                  'attribute' => 'satuan_id',
                  'value' => 'satuan.nama'
               ],
               [
                  'class' => '\yii\grid\DataColumn',
                  'attribute' => 'harga_beli',
                  'format' => ['decimal', 2],
                  'contentOptions' => [
                     'class' => 'text-end'
                  ]
               ],
               [
                  'class' => '\yii\grid\DataColumn',
                  'attribute' => 'harga_jual',
                  'format' => ['decimal', 2],
                  'contentOptions' => [
                     'class' => 'text-end'
                  ]
               ],
            ]
         ]) :
         Html::tag("p", 'Barang Satuan tidak tersedia', [
            'class' => 'text-warning font-weight-bold p-3'
         ]);
   } catch (Exception $e) {
      echo $e->getMessage();
   } catch (Throwable $e) {
      echo $e->getMessage();
   }
   ?>
</div>