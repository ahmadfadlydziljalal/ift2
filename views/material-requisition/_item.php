<?php

/* @var $model MaterialRequisition */

/* @see \app\controllers\MaterialRequisitionController::actionExpandItem() */

use app\enums\TextLinkEnum;
use app\models\base\MaterialRequisition;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;

?>

<div class="material-requisition-item py-1">

   <?php if ($this->context->action->id == 'expand-item'): ?>
       <div class="d-flex flex-row gap-2 mb-2">
          <?= Html::a(TextLinkEnum::PRINT->value, ['material-requisition/print-to-pdf', 'id' => $model->id], [
             'class' => 'btn btn-success',
             'target' => '_blank',
             'rel' => 'noopener noreferrer'
          ]); ?>
          <?= Html::a(Html::tag('div', TextLinkEnum::PRINT->value . ' Penawaran', ['class' => 'd-flex flex-row gap-1']), ['material-requisition/print-penawaran-to-pdf', 'id' => $model->id], [
             'class' => 'btn btn-success',
             'target' => '_blank',
             'rel' => 'noopener noreferrer'
          ]); ?>
          <?= Html::a(TextLinkEnum::VIEW->value, ['material-requisition/view', 'id' => $model->id], [
             'class' => 'btn btn-primary'
          ]); ?>
          <?= Html::a(TextLinkEnum::UPDATE->value, ['material-requisition/update', 'id' => $model->id], [
             'class' => 'btn btn-primary'
          ]); ?>
          <?= Html::a(TextLinkEnum::DELETE->value, ['material-requisition/delete', 'id' => $model->id], [
             'class' => 'btn btn-danger',
             'data' => [
                'confirm' => 'Are you sure to delete this item ?',
                'method' => 'post'
             ]
          ]); ?>
       </div>
   <?php endif; ?>

   <?php
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
   } ?>
</div>