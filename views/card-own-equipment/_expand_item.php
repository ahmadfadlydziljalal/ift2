<?php

use app\models\CardOwnEquipmentHistory;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;

/* @var $this View */
/* @var $model CardOwnEquipmentHistory */
?>


<div class="card-own-equipment-expand-item ">

    <div class="p-3">
        <h3 class="fw-bold"><i class="bi bi-info-circle"></i> 10 service terakhir</h3>
    </div>

   <?= GridView::widget([
      'dataProvider' => new ActiveDataProvider([
         'query' => $model->getCardOwnEquipmentHistories()->limit(10)->orderBy('id ASC')
      ]),
      'layout' => '{items}',
      'columns' => require(__DIR__ . '/_columns_history_service.php')
   ]) ?>
</div>