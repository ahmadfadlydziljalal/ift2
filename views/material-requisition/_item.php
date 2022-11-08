<?php

/* @var $model MaterialRequisition */

use app\models\base\MaterialRequisition;
use yii\data\ArrayDataProvider;
use yii\widgets\ListView;

try {
    echo ListView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->getMaterialRequisitionDetailsGroupingByTipePembelian()
        ]),
        'options' => [
            'class' => 'd-flex flex-column gap-2'
        ],
        'itemView' => function ($model, $key, $index) {
            return $this->render('_item_group', [
                'models' => $model,
                'key' => $key,
                'index' => $index
            ]);
        },
        'layout' => '{items}'
    ]);
} catch (Throwable $e) {
    echo $e->getTraceAsString();
}