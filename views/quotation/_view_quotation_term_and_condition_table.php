<?php

/* @var $this yii\web\View */

/* @var $model app\models\Quotation|string|yii\db\ActiveRecord */

use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;

?>

<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider'     => new ActiveDataProvider([
            'query'      => $model->getQuotationTermAndConditions(),
            'pagination' => false,
            'sort'       => false
        ]),
        'layout'           => '{items}',
        'headerRowOptions' => [
            'class' => 'text-wrap text-center align-middle'
        ],
        'columns'          => [
            [
                'class' => SerialColumn::class,
            ],
            [
                'class'     => DataColumn::class,
                'attribute' => 'term_and_condition'
            ]
        ],
        'showFooter'       => false,
    ]) ?>
</div>
