<?php


/* @var $this View */

/* @var $model Quotation */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use app\models\QuotationBarang;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

?>

<div class="card bg-transparent" id="barang">
    <div class="card-body">
        <div class="d-flex flex-column gap-3">
            <div class="d-flex flex-row gap-2">
               <?php if (!$model->quotationBarangs) : ?>

                  <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-barang-quotation', 'id' => $model->id], [
                     'class' => 'btn btn-success'
                  ]) ?>

               <?php else : ?>

                  <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-barang-quotation', 'id' => $model->id], [
                     'class' => 'btn btn-primary'
                  ]) ?>

                  <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-barang-quotation', 'id' => $model->id], [
                     'class' => 'btn btn-danger',
                     'data-method' => 'post',
                     'data-confirm' => 'Apakah Anda akan menghapus detail quotation barang ini ?'
                  ]) ?>

               <?php endif; ?>
            </div>

            <div class="table-responsive">
               <?php try {
                  echo GridView::widget(config: [
                     'dataProvider' => new ActiveDataProvider([
                        'query' => $model->getQuotationBarangs(),
                        'pagination' => false,
                        'sort' => false
                     ]),
                     'showPageSummary' => false,
                     'headerRowOptions' => [
                        'class' => 'text-wrap text-center align-middle'
                     ],
                     'layout' => '{items}',
                     'columns' => [
                        [
                           'class' => SerialColumn::class,
                           'footer' => '',
                           'footerOptions' => [
                              'colspan' => 8
                           ]
                        ],
                        [
                           'class' => DataColumn::class,
                           'attribute' => 'barang_id',
                           'value' => 'barang.nama',
                           'footerOptions' => [
                              'hidden' => true
                           ]
                        ],
                        [
                           'class' => DataColumn::class,
                           'attribute' => 'satuan_id',
                           'value' => 'satuan.nama',
                           'footerOptions' => [
                              'hidden' => true
                           ]
                        ],
                        [
                           'class' => DataColumn::class,
                           'attribute' => 'stock',
                           'contentOptions' => [
                              'class' => 'text-end'
                           ],
                           'footerOptions' => [
                              'hidden' => true
                           ]
                        ],
                        [
                           'class' => DataColumn::class,
                           'attribute' => 'quantity',
                           'contentOptions' => [
                              'class' => 'text-end'
                           ],
                           'footerOptions' => [
                              'hidden' => true
                           ]
                        ],
                        [
                           'class' => DataColumn::class,
                           'header' => '',
                           'contentOptions' => [
                              'class' => 'text-end'
                           ],
                           'value' => 'quotation.mataUang.singkatan',
                           'footerOptions' => [
                              'hidden' => true
                           ]
                        ],
                        [
                           'class' => DataColumn::class,
                           'attribute' => 'unit_price',
                           'format' => ['decimal', 2],
                           'contentOptions' => [
                              'class' => 'text-end'
                           ],
                           'footerOptions' => [
                              'hidden' => true
                           ]
                        ],
                        [
                           'class' => DataColumn::class,
                           'attribute' => 'discount',
                           'contentOptions' => [
                              'class' => 'text-end'
                           ],
                           'footerOptions' => [
                              'hidden' => true
                           ]
                        ],
                        [
                           'class' => DataColumn::class,
                           'attribute' => 'discount_nominal',
                           'contentOptions' => [
                              'class' => 'text-end'
                           ],
                           'value' => function ($model) {
                              /** @var QuotationBarang $model */
                              /** @see QuotationBarang::getNominalDiscount() */
                              return $model->nominalDiscount;
                           },
                           'format' => ['decimal', 2],
                           'footer' => 'Total',
                           'footerOptions' => [
                              'colspan' => 2
                           ]
                        ],
                        [
                           'class' => DataColumn::class,
                           'attribute' => 'unit_price_after_discount',
                           'contentOptions' => [
                              'class' => 'text-end'
                           ],
                           'value' => function ($model) {
                              /** @var QuotationBarang $model */
                              /** @see QuotationBarang::getUnitPriceAfterDiscount() */
                              return $model->unitPriceAfterDiscount;
                           },
                           'format' => ['decimal', 2],
                           'footerOptions' => [
                              'hidden' => true
                           ]
                        ],
                        [
                           'class' => DataColumn::class,
                           'attribute' => 'amount',
                           'contentOptions' => [
                              'class' => 'text-end'
                           ],
                           'value' => function ($model) {
                              /** @var QuotationBarang $model */
                              /** @see QuotationBarang::getAmount() $model */
                              return $model->amount;
                           },
                           'format' => ['decimal', 2],
                           'footer' => Yii::$app->formatter->asDecimal($model->quotationBarangsTotal, 2), /* @see \app\models\Quotation::getQuotationBarangsTotal() */
                           'footerOptions' => [
                              'class' => 'text-end'
                           ]
                        ],
                     ],
                     'showFooter' => true,
                     'beforeFooter' => [
                        [
                           'columns' => [
                              [
                                 'content' =>
                                    Html::tag('p', "Note:", ['class' => 'fw-bold']) .
                                    Html::tag(
                                       'p',
                                       !empty($model->catatan_quotation_barang)
                                          ? nl2br($model->catatan_quotation_barang)
                                          : '',
                                       ['class' => 'fw-normal']
                                    ),
                                 'options' => [
                                    'colspan' => 8,
                                    'rowspan' => 4,
                                    'style' => [
                                       'vertical-align' => 'top'
                                    ]
                                 ]
                              ],
                              [
                                 'content' => 'Subtotal',
                                 'options' => [
                                    'colspan' => 2
                                 ]
                              ],
                              [
                                 'content' => Yii::$app->formatter->asDecimal($model->getQuotationBarangsSubtotal(), 2),
                                 'options' => [
                                    'class' => 'text-end',
                                 ]
                              ],
                           ],
                        ],
                        [
                           'columns' => [
                              [
                                 'content' => 'Delivery Fee',
                                 'options' => [
                                    'colspan' => 2
                                 ]
                              ],
                              [
                                 'content' => Yii::$app->formatter->asDecimal($model->delivery_fee, 2),
                                 'options' => [
                                    'class' => 'text-end'
                                 ]
                              ],
                           ],

                        ],
                        [
                           'columns' => [
                              [
                                 'content' => 'DPP',
                                 'options' => [
                                    'colspan' => 2
                                 ]
                              ],
                              [
                                 /* @see \app\models\Quotation::getQuotationBarangsDasarPengenaanPajak() */
                                 'content' => Yii::$app->formatter->asDecimal($model->quotationBarangsDasarPengenaanPajak, 2),
                                 'options' => [
                                    'class' => 'text-end'
                                 ]
                              ],
                           ],

                        ],
                        [
                           'columns' => [
                              [
                                 'content' => 'PPN',
                                 'options' => [
                                    'colspan' => 2
                                 ]
                              ],
                              [
                                 /* @see \app\models\Quotation::getQuotationBarangsTotalVatNominal() */
                                 'content' => Yii::$app->formatter->asDecimal($model->quotationBarangsTotalVatNominal, 2),
                                 'options' => [
                                    'class' => 'text-end'
                                 ]
                              ],
                           ],
                           
                        ],

                     ],
                  ]);
               } catch (Throwable $e) {
                  echo $e->getMessage();
               } ?>
            </div>
        </div>

    </div>


</div>