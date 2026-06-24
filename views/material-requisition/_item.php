<?php

/* @var $model MaterialRequisition */

/* @see \app\controllers\MaterialRequisitionController::actionExpandItem() */

/* @var $this View */

use app\models\base\MaterialRequisition;
use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\widgets\ListView;

?>

<div class="material-requisition-item py-1">

    <?php
    try {
        echo ListView::widget([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $model->getMaterialRequisitionDetailsGroupingByTipePembelian()
            ]),
            'options'      => [
                'class' => 'd-flex flex-column gap-2'
            ],
            'itemView'     => function ($model, $key, $index) {
                /** @see views/material-requisition/_item_group.php */
                return $this->render('_item_group', [
                    'models' => $model,
                    'key'    => $key,
                    'index'  => $index
                ]);
            },
            'layout'       => '{items}'
        ]);
    } catch (Throwable $e) {
        echo $e->getTraceAsString();
    } ?>
</div>