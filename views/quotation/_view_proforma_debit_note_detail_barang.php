<?php


/* @var $this View */

/* @var $model Quotation|string|ActiveRecord */

use app\enums\TextLinkEnum;
use app\models\ProformaDebitNoteDetailBarang;
use app\models\Quotation;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;

?>

<div class="d-flex flex-column">
    <h2 class="fw-bold">Barang</h2>
    <div class="d-flex flex-column gap-3">
        <div>
           <?php if (!$model->proformaDebitNote->proformaDebitNoteDetailBarangs) : ?>

              <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-proforma-debit-note-detail-barang', 'id' => $model->proformaDebitNote->id], [
                 'class' => 'btn btn-success'
              ]) ?>

           <?php else : ?>

              <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-proforma-debit-note-detail-barang', 'id' => $model->proformaDebitNote->id], [
                 'class' => 'btn btn-primary'
              ]) ?>

              <?php /* @see \app\controllers\QuotationController::actionDeleteProformaDebitNoteDetailBarang() */ ?>
              <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-proforma-debit-note-detail-barang', 'id' => $model->proformaDebitNote->id], [
                 'class' => 'btn btn-danger',
                 'data-method' => 'post',
                 'data-confirm' => 'Apakah Anda akan menghapus detail proforma debit note ini ?'
              ]) ?>

           <?php endif; ?>
        </div>
       <?php if ($model->proformaDebitNote->proformaDebitNoteDetailBarangs) : ?>

           <div class="table-responsive">
              <?php
              try {
                 echo GridView::widget([
                    'dataProvider' => new ActiveDataProvider([
                       'query' => $model->proformaDebitNote->getProformaDebitNoteDetailBarangs(),
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
                          'value' => 'proformaDebitNote.quotation.mataUang.singkatan',
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
                             /** @var ProformaDebitNoteDetailBarang $model */
                             /** @see ProformaDebitNoteDetailBarang::getNominalDiscount() */
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
                             /** @var ProformaDebitNoteDetailBarang $model */
                             /** @see ProformaDebitNoteDetailBarang::getUnitPriceAfterDiscount() */
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
                             /** @var ProformaDebitNoteDetailBarang $model */
                             /** @see ProformaDebitNoteDetailBarang::getAmount() $model */
                             return $model->amount;
                          },
                          'format' => ['decimal', 2],
                          'footer' => Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteDetailBarangsTotal, 2), /* @see Quotation::getQuotationBarangsTotal */
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
                                'content' => Yii::$app->formatter->asDecimal($model->proformaDebitNote->getProformaDebitNoteDetailBarangsSubtotal(), 2),
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
                                /* @see \app\models\ProformaDebitNOte::getQuotationBarangsDasarPengenaanPajak */
                                'content' => Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteDetailBarangsDasarPengenaanPajak, 2),
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
                                /* @see \app\models\ProformaDebitNote::getQuotationBarangsTotalVatNominal */
                                'content' => Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteDetailBarangsTotalVatNominal, 2),
                                'options' => [
                                   'class' => 'text-end'
                                ]
                             ],
                          ],

                       ],

                    ],
                 ]);
              } catch (Throwable $e) {
                 echo $e->getTraceAsString();
              } ?>
           </div>

       <?php endif; ?>
    </div>
</div>