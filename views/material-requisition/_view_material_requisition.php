<?php


/* @var $this View */

/* @var $model MaterialRequisition|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\MaterialRequisition;
use app\models\User;
use yii\bootstrap5\Html;
use yii\db\ActiveRecord;
use yii\web\View;
use yii\widgets\DetailView;

?>

<div class="material-requisition-view">
    <div class="d-flex flex-row gap-1 mb-3">
       <?= Html::a(TextLinkEnum::PRINT->value, ['material-requisition/print-to-pdf', 'id' => $model->id], [
          'class' => 'btn btn-success',
          'target' => '_blank',
          'rel' => 'noopener noreferrer'
       ]) ?>

       <?= Html::a(TextLinkEnum::UPDATE->value, ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
   <?php try {
      echo DetailView::widget([
         'model' => $model,
         'options' => [
            'class' => 'table table-bordered table-detail-view'
         ],
         'attributes' => [
            'nomor',
            [
               'attribute' => 'vendor_id',
               'value' => $model->vendor->nama,
            ],
            'tanggal:date',
            'remarks:ntext',
            [
               'attribute' => 'approved_by',
               'value' => $model->approvedBy->nama,
            ],
            [
               'attribute' => 'acknowledge_by',
               'value' => $model->acknowledgeBy->nama,
            ],
            [
               'attribute' => 'created_at',
               'format' => 'datetime',
            ],
            /*[
                'attribute' => 'updated_at',
                'format' => 'datetime',
            ],*/
            [
               'attribute' => 'created_by',
               'value' => function ($model) {
                  return User::findOne($model->created_by)->username ?? null;
               }
            ],
            /*[
                  'attribute' => 'updated_by',
                  'value' => function ($model) {
                      return User::findOne($model->updated_by)->username ?? null;
                  }
            ],*/
         ],
      ]);


   } catch (Exception $e) {
      echo $e->getMessage();
   } catch (Throwable $e) {
      echo $e->getMessage();
   }
   ?>
</div>