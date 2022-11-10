<?php


/* @var $this View */
/* @var $model PurchaseOrder */

/* @see \app\controllers\PurchaseOrderController::actionExpandItem() */

use app\models\PurchaseOrder;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;

?>

<div class="purchase-order-item py-1">
    <?php
    try {
        echo GridView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => $model->getMaterialRequisitionDetailPenawarans(),
                'pagination' => false,
                'sort' => false
            ]),
            'layout' => '{items}',
            'headerRowOptions' => [
                'class' => 'table table-primary'
            ],
            'columns' => require __DIR__ . '/_penawaran_columns.php'
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>
</div>