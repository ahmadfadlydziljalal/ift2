<?php

use app\enums\TextLinkEnum;
use mdm\admin\components\Helper;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MaterialRequisition */
/* @see \app\controllers\MaterialRequisitionController::actionView() */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Material Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-requisition-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
           <?= Html::a(TextLinkEnum::LIST->value, ['index'], ['class' => 'btn btn-outline-primary']) ?>
           <?= Html::a(TextLinkEnum::BUAT_LAGI->value, ['create'], ['class' => 'btn btn-success']) ?>

        </div>
    </div>
    <div class="d-flex flex-row gap-1 mb-3">
       <?= Html::a(TextLinkEnum::KEMBALI->value, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>

       <?php
       if (Helper::checkRoute('delete')) :
          echo Html::a(TextLinkEnum::DELETE->value, ['delete', 'id' => $model->id], [
             'class' => 'btn btn-outline-danger',
             'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
             ],
          ]);
       endif;
       ?>
    </div>

   <?php
   try {
      echo Tabs::widget([
         'options' => [
            'class' => 'nav nav-pills'
         ],
         'itemOptions' => [
            'class' => 'pt-3'
         ],
         'headerOptions' => [
            'class' => 'pb-3'
         ],
         'items' => [
            [
               'label' => 'Material Request',
               'content' => $this->render('_view_material_requisition', [
                  'model' => $model
               ]),
            ],
            [
               'label' => 'Penawaran Harga',
               'content' => $this->render('_view_penawaran_harga', [
                  'model' => $model
               ]),
            ],

         ],
      ]);
   } catch (Throwable $e) {
      echo $e->getMessage();
   }
   ?>

</div>