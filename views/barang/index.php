<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\BarangSearch */
/* @see \app\controllers\BarangController */

/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Barang';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="barang-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
           <?= Html::a('<i class="bi bi-repeat"></i>' . ' Reset Filter', ['index'], ['class' => 'btn btn-primary']) ?>
           <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

   <?php
   /* try {
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item',
            'itemOptions' => [
                'class' => 'mb-3'
            ]
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }*/

   ?>

   <?php try {
      echo GridView::widget([
         'tableOptions' => [
            'class' => 'table table-bordered table-grid-view table-fixes-last-column'
         ],
         'pjax' => true,
         'dataProvider' => $dataProvider,
         'filterModel' => $searchModel,
         'rowOptions' => [
            'class' => 'align-middle'
         ],
         'columns' => require(__DIR__ . '/_columns.php'),
      ]);
   } catch (Exception $e) {
      echo $e->getMessage();
   } catch (Throwable $e) {
      echo $e->getMessage();
   }
   ?>

</div>