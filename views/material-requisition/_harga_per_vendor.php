<?php

use kartik\grid\GridView;
use yii\data\ArrayDataProvider;

echo GridView::widget([
    'id' => 'gv-' . $key,
    'dataProvider' => new ArrayDataProvider([
        'allModels' => $model
    ]),
    'columns' => []
]);