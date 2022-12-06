<?php

use app\enums\TextLinkEnum;
use mdm\admin\components\Helper;
use yii\bootstrap5\Tabs;
use yii\helpers\Html;

/* @var $links array */
/* @var $this yii\web\View */
/* @var $model app\models\Quotation */
/* @see app\controllers\QuotationController::actionView() */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="quotation-view">

        <div class="d-flex flex-column gap-3">
            <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
                <h1><?= Html::encode($model->getNomorDisplay()) ?></h1>
                <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
                   <?= Html::a(TextLinkEnum::KEMBALI->value, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
                   <?= Html::a(TextLinkEnum::PRINT->value, ['print', 'id' => $model->id], [
                      'class' => 'btn btn-success',
                      'target' => '_blank',
                      'rel' => 'noopener noreferrer'
                   ]) ?>

                   <?php
                   if (Helper::checkRoute('delete')) :
                      echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                         'class' => 'btn btn-outline-danger',
                         'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                         ],
                      ]);
                   endif;
                   ?>
                   <?= Html::a(TextLinkEnum::LIST->value, ['index'], ['class' => 'btn btn-outline-primary']) ?>
                   <?= Html::a(TextLinkEnum::BUAT_LAGI->value, ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>

           <?php
           try {
              echo Tabs::widget([
                 'options' => [
                    'class' => 'nav nav-pills nav-fill',
                    'id' => 'quotation-tab'
                 ],
                 'itemOptions' => [
                    'class' => 'pt-1'
                 ],
                 'headerOptions' => [
                    'class' => 'pb-3'
                 ],
                 'items' => [
                    [
                       'label' => 'Quotation',
                       'content' => $this->render('_view_quotation', ['model' => $model]),
                       // 'active' => true,
                       // 'url' => '#quotation-tab-quotation'
                    ],
                    [
                       'label' => 'Barang',
                       'content' => $this->render('_view_quotation_barang', ['model' => $model]),
                       // 'url' => '#quotation-tab-barang'
                    ],
                    [
                       'label' => 'Service',
                       'content' => $this->render('_view_quotation_service', ['model' => $model]),
                       // 'url' => '#quotation-tab-service',
                    ],
                    [
                       'label' => 'Term & Condition',
                       'content' => $this->render('_view_quotation_term_and_condition', ['model' => $model]),
                       // 'url' => '#quotation-tab-term-and-condition',
                    ],
                    [
                       'label' => 'Form Job',
                       'content' => $this->render('_view_form_job', ['model' => $model]),
                       // 'url' => '#quotation-tab-form-job',
                    ],
                    [
                       'label' => 'Delivery Receipt',
                       'content' => $this->render('_view_delivery_receipt', ['model' => $model]),
                       // 'url' => '#quotation-tab-delivery-receipt',
                    ],
                    [
                       'label' => 'Summary',
                       'content' => $this->render('_view_summary', ['model' => $model]),
                       // 'url' => '#quotation-tab-summary',
                    ],
                 ],
              ]);
           } catch (Throwable $e) {
              echo $e->getMessage();
           }
           ?>
        </div>

    </div>

<?php

$js = <<<JS
jQuery(document).ready(function() {

  
  var hash = window.location.hash;
  hash && $('ul.nav.nav-pills a[href="' + hash + '"]').tab('show'); 
  $('ul.nav.nav-pills a').click(function (e) {
     $(this).tab('show');
     var scrollmem = $('body').scrollTop() || $('html').scrollTop();
     window.location.hash = this.hash;
     $('html,body').scrollTop(scrollmem);
  });

  
});
JS;
$this->registerJs($js);