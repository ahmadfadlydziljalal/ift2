<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MaterialRequisitionSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\widgets\modal_ajax\ModalAjaxWidget;
use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Material Requisition';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('.table-responsive{ min-height: 400px }');

?>
<div class="material-requisition-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
           <?= Html::a('<i class="bi bi-repeat"></i>' . ' Reset Filter', ['index'], ['class' => 'btn btn-primary']) ?>
           <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

   <?php try {
      echo GridView::widget([
         'id' => 'gridview-master',
         'dataProvider' => $dataProvider,
         'filterModel' => $searchModel,
         'columns' => require(__DIR__ . '/_columns.php'),
         'rowOptions' => function ($model, $key, $index, $grid) {
            return [
               'data-id' => $model->id,
               'class' => 'align-middle text-nowrap'
            ];
         }
      ]);
   } catch (Exception $e) {
      echo $e->getMessage();
   } catch (Throwable $e) {
      echo $e->getMessage();
   }
   ?>

   <?= ModalAjaxWidget::widget(); ?>

</div>