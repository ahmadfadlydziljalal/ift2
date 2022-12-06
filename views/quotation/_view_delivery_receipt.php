<?php


/* @var $this View */
/* @see \app\controllers\QuotationController::actionCreateDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionUpdateDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionDeleteDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionDeleteAllDeliveryReceipt() */
/* @see \app\controllers\QuotationController::actionPrintDeliveryReceipt() */

/* @var $model Quotation */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ListView;

?>

<div class="card bg-transparent" id="delivery-receipt">

    <div class="card-body">
        <div class="d-flex flex-column gap-3">
            <div class="d-flex flex-row gap-2">

               <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-delivery-receipt', 'id' => $model->id], [
                  'class' => 'btn btn-success'
               ]) ?>

               <?= Html::a(TextLinkEnum::DELETE_ALL->value, ['quotation/delete-all-delivery-receipt', 'id' => $model->id], [
                  'class' => 'btn btn-danger',
                  'data-method' => 'post',
                  'data-confirm' => 'Apakah Anda akan menghapus delivery receipt ini ?'
               ]) ?>
            </div>

            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="table-responsive">
                       <?php

                       if ($model->quotationDeliveryReceipts) {
                          echo ListView::widget([
                             'dataProvider' => new ActiveDataProvider([
                                'query' => $model->getQuotationDeliveryReceipts(),
                                'pagination' => false,
                                'sort' => false
                             ]),
                             'itemView' => '_item_quotation_deliver_receipt',
                             'layout' => '{items}',
                             'options' => [
                                'class' => 'd-flex flex-column gap-3'
                             ]
                          ]);
                       } else {
                          echo Html::tag('p', 'Belum ada form job', [
                             'class' => 'text-danger font-weight-bold'
                          ]);
                       }
                       ?>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="card bg-transparent">

                        <div class="card-body border-bottom fw-bold">
                            <i class="bi bi-file-pdf"></i> Summary Indent
                        </div>

                        <div class="card-body">
                            <p class="font-weight-bold">
                                Status: <?= $model->getGlobalStatusDeliveryReceiptInHtmlFormat() ?>
                            </p>
                            <div class="table-responsive">
                               <?= GridView::widget([
                                  'dataProvider' => new ActiveDataProvider([
                                     'query' => $model->getListDeliveryReceiptDetails(),
                                     'pagination' => false,
                                     'sort' => false
                                  ]),
                                  'columns' => [
                                     [
                                        'class' => SerialColumn::class
                                     ],
                                     [
                                        'class' => DataColumn::class,
                                        'attribute' => 'barangNama'
                                     ],
                                     [
                                        'class' => DataColumn::class,
                                        'attribute' => 'quotationBarangQuantity',
                                        'header' => 'Quotation Qty',
                                        'format' => ['decimal', 2],
                                        'contentOptions' => [
                                           'class' => 'text-end'
                                        ]
                                     ],
                                     [
                                        'class' => DataColumn::class,
                                        'attribute' => 'quantity',
                                        'header' => 'Qty Dikirim',
                                        'format' => ['decimal', 2],
                                        'contentOptions' => [
                                           'class' => 'text-end'
                                        ]
                                     ],
                                     [
                                        'class' => DataColumn::class,
                                        'attribute' => 'totalQuantityIndent',
                                        'header' => 'Indent',
                                        'format' => ['decimal', 2],
                                        'contentOptions' => [
                                           'class' => 'text-end'
                                        ]
                                     ],
                                  ],
                                  'layout' => '{items}',
                                  'rowOptions' => function ($model, $key, $index) {
                                     if (!empty($model->totalQuantityIndent)) {
                                        return [
                                           'class' => 'table-danger'
                                        ];
                                     }
                                  }
                               ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>