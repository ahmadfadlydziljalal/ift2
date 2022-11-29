<?php


/* @var $this View */

/* @var $model MaterialRequisition|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\MaterialRequisition;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;
use yii\widgets\ListView;

?>

<div class="material-requisition-view">
    <div class="d-flex flex-row gap-1 mb-3">
       <?= Html::a(TextLinkEnum::PRINT->value, ['material-requisition/print-penawaran', 'id' => $model->id], [
          'class' => 'btn btn-success',
          'target' => '_blank',
          'rel' => 'noopener noreferrer'
       ]) ?>
    </div>

   <?php
   echo ListView::widget([
      'dataProvider' => new ActiveDataProvider([
         'query' => $model->getMaterialRequisitionDetails()
      ]),
      'itemView' => function ($model, $key, $index, $widget) {
         return $this->render('_view_detail_penawaran', [
            'model' => $model
         ]);
      },
      'options' => [
         'class' => 'd-flex flex-column gap-3 '
      ]
   ]);
   ?>
</div>