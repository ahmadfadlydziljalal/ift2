<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\HistoryLokasiBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\HistoryLokasiBarangController::actionIndex() */

$this->title = 'History Lokasi Barang';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="history-lokasi-barang-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
           <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

   <?php try {
      echo GridView::widget([
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