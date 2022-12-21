<?php

use app\assets\Bootstrap5VerticalTabs;
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

Bootstrap5VerticalTabs::register($this);

?>
<div class="material-requisition-view">

   <?php if (!Yii::$app->request->isAjax) : ?>
       <div class="d-flex justify-content-between flex-wrap mb-3" style="gap: .5rem">

           <h1><?= Html::encode($this->title) ?></h1>

           <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
              <?= Html::a(TextLinkEnum::LIST->value, ['index'], ['class' => 'btn btn-outline-primary']) ?>
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

              <?= Html::a(TextLinkEnum::BUAT_LAGI->value, ['create'], ['class' => 'btn btn-success']) ?>
           </div>
       </div>
   <?php endif; ?>

    <div class="row flex-row-reverse">
       <?php
       try {
          echo Tabs::widget([
             'options' => [
                'class' => 'nav nav-pills left-tabs m-0 col-md-3',
                'id' => 'material-requisition-tab',
                'aria-orientation' => 'vertical',
                'role' => 'tablist'
             ],
             'tabContentOptions' => [
                'class' => 'col-md-9 pt-0'
             ],
             'itemOptions' => [
                'class' => 'p-0 pt-3 pt-md-0 pt-lg-0 '
             ],
             'headerOptions' => [
                'class' => 'p-0 text-nowrap text-start '
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

   <?php if (!Yii::$app->request->isAjax) : ?>
       <div class="d-flex flex-row gap-1 mb-3">

          <?php
          $prev = $model->previous;
          if ($prev) {
             echo Html::a(' Prev ',
                ['material-requisition/view', 'id' => $prev->id],
                [
                   'class' => 'btn btn-outline-primary'
                ]
             );
          } ?>

           <div class="ml-auto">
              <?php
              $next = $model->next;
              if ($next) {
                 echo Html::a(
                    'Next',
                    ['material-requisition/view', 'id' => $next->id],
                    [
                       'class' => 'btn btn-outline-primary'
                    ]
                 );
              }
              ?>
           </div>
       </div>
   <?php endif; ?>

</div>