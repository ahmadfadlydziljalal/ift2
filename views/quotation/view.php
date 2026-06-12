<?php

use app\assets\Bootstrap5VerticalTabs;
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

//$this->registerCssFile('https://cdn.jsdelivr.net/npm/bootstrap-5-vertical-tabs@2.0.0/dist/b5vtabs.min.css', [
//   'integrity' => 'sha384-AsoWNxsuu73eGp2MPWHa77155fyqP9rueKOeG4t2d/AD4eyBqL20TClzfbAkrul4',
//   'crossorigin' => 'anonymous'
//]);

Bootstrap5VerticalTabs::register($this);
?>

    <div class="quotation-view">

        <div class="d-flex flex-column gap-3">
            <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
                <h1><?= Html::encode($model->nomor) ?></h1>
                <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
                    <?= Html::a('<i class="bi bi-arrow-left-circle"></i>', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
                    <?php
                    if (Helper::checkRoute('delete')) :
                        echo Html::a(TextLinkEnum::HAPUS->value, ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data'  => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method'  => 'post',
                            ],
                        ]);
                    endif;
                    ?>
                    <?= Html::a('Buat Quotation Lainnya', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <div class="row flex-row-reverse">
                <?php
                try {
                    echo Tabs::widget([
                        'options'           => [
                            'class'            => 'nav nav-pills left-tabs m-0 col-md-3',
                            'id'               => 'quotation-tab',
                            'aria-orientation' => 'vertical',
                            'role'             => 'tablist'
                        ],
                        'tabContentOptions' => [
                            'class' => 'col-md-9 pt-0'
                        ],
                        'itemOptions'       => [
                            'class' => 'p-0 '
                        ],
                        'headerOptions'     => [
                            'class' => 'p-0 text-nowrap text-start '
                        ],
                        'items'             => [
                            [
                                'label'   => 'Master Quotation',
                                'content' => $this->render('_view_quotation', ['model' => $model]),
                                // 'active' => true,
                                // 'url' => '#quotation-tab-quotation'
                            ],
                            [
                                'label'   => 'Barang',
                                'content' => $this->render('_view_quotation_barang', ['model' => $model]),
                                // 'url' => '#quotation-tab-barang'
                            ],
                            [
                                'label'   => 'Service',
                                'content' => $this->render('_view_quotation_service', ['model' => $model]),
                                // 'url' => '#quotation-tab-service',
                            ],
                            [
                                'label'   => 'Term & Condition',
                                'content' => $this->render('_view_quotation_term_and_condition', ['model' => $model]),
                                // 'url' => '#quotation-tab-term-and-condition',
                            ],

                            [
                                'label'   => 'Form Job',
                                'content' => $this->render('_view_form_job', ['model' => $model]),
                                // 'url' => '#quotation-tab-form-job',
                            ],
                            [
                                'label'   => 'Delivery Receipt',
                                'content' => $this->render('_view_delivery_receipt', ['model' => $model]),
                                // 'url' => '#quotation-tab-delivery-receipt',
                            ],
                            [
                                'label'   => 'Summary',
                                'content' => $this->render('_view_summary', ['model' => $model]),
                                // 'url' => '#quotation-tab-summary',
                            ],
                            [
                                'label'   => 'Proforma Invoice',
                                'content' => $this->render('_view_proforma_invoice', ['model' => $model]),
                            ],
                            [
                                'label'   => 'Proforma Debit Note',
                                'content' => $this->render('_view_proforma_debit_note', ['model' => $model]),
                            ],
                        ],
                    ]);
                } catch (Throwable $e) {
                    echo $e->getMessage() . $e->getTraceAsString();
                }
                ?>
            </div>
        </div>

    </div>

<?php
//
//$js = <<<JS
//jQuery(document).ready(function() {
//  var hash = window.location.hash;
//  hash && $('ul.nav.nav-pills a[href="' + hash + '"]').tab('show');
//  $('ul.nav.nav-pills a').click(function (e) {
//     $(this).tab('show');
//     var scrollmem = $('body').scrollTop() || $('html').scrollTop();
//     window.location.hash = this.hash;
//     $('html,body').scrollTop(scrollmem);
//  });
//});
//JS;
//$this->registerJs($js);