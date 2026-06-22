<?php

/* @var $model MaterialRequisition */

/* @var $this View */

use app\models\base\MaterialRequisition;
use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\widgets\ListView;


echo ListView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $model->getMaterialRequisitionDetailsGroupingByTipePembelian()
    ]),
    'options'      => [
        'class' => 'd-flex flex-column gap-3'
    ],
    'itemOptions'  => [
        'class' => 'mb-3'
    ],
    'itemView'     => function ($model, $key, $index, $widget) {
        /** @see views/material-requisition/_item_penawaran_harga_group.php */
        return $this->render('_item_penawaran_harga_group', [
            'model' => $model,
            'key'   => $key,
        ]);
    },
    'layout'       => '{items}'
]);