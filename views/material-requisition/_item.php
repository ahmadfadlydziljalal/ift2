<?php

/* @var $model MaterialRequisition */

use app\models\base\MaterialRequisition;
use yii\data\ArrayDataProvider;
use yii\widgets\ListView;

echo ListView::widget([
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $model->getMaterialRequisitionDetailsGroupingByTipePembelian()
    ]),
    'options' => [
        'class' => 'd-flex flex-column gap-3'
    ],
    'itemOptions' => [
        'class' => 'mb-3'
    ],
    'itemView' => function ($model, $key, $index, $widget) {
        return $this->render('_item_group', [
            'model' => $model,
            'key' => $key
        ]);
    },
    'layout' => '{items}'
]);