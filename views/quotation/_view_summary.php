<?php


/* @var $this View */

/* @var $model Quotation|string|ActiveRecord */

use app\models\Quotation;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;

?>

<div id="summary">

    <div class="row rows-col-sm-1 rows-col-md-2">
        <div class="col">
            <h2>Quotation</h2>
            <table class="table table-bordered">

                <tbody>
                <tr class="table-success">
                    <th>No</th>
                    <th>Fee (Sebelum Discount)</th>
                    <th></th>
                    <th class="text-end">Nominal</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Material (Barang) Fee</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationBarangsBeforeDiscountSubtotal, 2) ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Delivery Fee</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->delivery_fee, 2) ?></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>Service Fee</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationServicesBeforeDiscountDasarPengenaanPajak, 2) ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Materai Fee</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->materai_fee, 2) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-end fw-bold">Total</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->getQuotationFeeTotal(), 2) ?></td>
                </tr>
                </tbody>

                <!-- Tax -->
                <tbody>
                <tr class="table-warning">
                    <th>No</th>
                    <th>Tax</th>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <th class="text-end">Nominal</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Barang</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationBarangsTotalVatNominal, 2) ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Service</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationServicesTotalVatNominal, 2) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-end fw-bold">Total</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->quotationVatTotal, 2) ?></td>
                </tr>


                </tbody>

                <!-- Discount -->
                <tbody>
                <tr class="table-info">
                    <th>No</th>
                    <th>Discount</th>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <th class="text-end">Nominal</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Barang</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end">
                        <?= Yii::$app->formatter->asDecimal($model->quotationBarangsDiscount, 2) ?>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Service</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end">
                        <?= Yii::$app->formatter->asDecimal($model->quotationServicesDiscount, 2) ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-end fw-bold">Total</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end fw-bold">
                        <?= Yii::$app->formatter->asDecimal($model->quotationDiscountTotal, 2) ?>
                    </td>
                </tr>
                </tbody>
                <tbody>
                <tr class="table-primary">
                    <td></td>
                    <td class="text-end fw-bold">Grand Total</td>
                    <td><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->quotationGrandTotal, 2) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col">

            <?php if ($model->proformaInvoice) : ?>
                <h2>Proforma Invoice (Sebelum Pph <?= $model->proformaInvoice->getPph23Label() ?>)</h2>
                <table class="table table-bordered">

                    <tbody>
                    <tr class="table-success">
                        <th>No</th>
                        <th>Fee (Sebelum Discount)</th>
                        <th></th>
                        <th class="text-end">Nominal</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Material (Barang) Fee</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceDetailBarangsBeforeDiscountSubtotal, 2) ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Delivery Fee</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->delivery_fee, 2) ?></td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Service Fee</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceDetailServicesBeforeDiscountDasarPengenaanPajak, 2) ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Materai Fee</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->materai_fee, 2) ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-end fw-bold">Total</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->proformaInvoice->getProformaInvoiceFeeTotal(), 2) ?></td>
                    </tr>
                    </tbody>

                    <!-- Tax -->
                    <tbody>
                    <tr class="table-warning">
                        <th>No</th>
                        <th>Tax</th>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <th class="text-end">Nominal</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Barang</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceDetailBarangsTotalVatNominal, 2) ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Service</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceDetailServicesTotalVatNominal, 2) ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-end fw-bold">Total</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceVatTotal, 2) ?></td>
                    </tr>


                    </tbody>

                    <!-- Discount -->
                    <tbody>
                    <tr class="table-info">
                        <th>No</th>
                        <th>Discount</th>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <th class="text-end">Nominal</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Barang</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end">
                            <?= Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceDetailBarangsDiscount, 2) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Service</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end">
                            <?= Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceDetailServicesDiscount, 2) ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-end fw-bold">Total</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end fw-bold">
                            <?= Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceDiscountTotal, 2) ?>
                        </td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr class="table-primary">
                        <td></td>
                        <td class="text-end fw-bold">Grand Total</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->proformaInvoice->proformaInvoiceGrandTotal, 2) ?></td>
                    </tr>
                    </tbody>
                </table>

            <?php endif; ?>

            <?php if ($model->proformaDebitNote) : ?>
                <hr/>
                <h2>Proforma Debit Note (Sebelum Pph <?= $model->proformaDebitNote->getPph23Label() ?>)</h2>
                <table class="table table-bordered">

                    <tbody>
                    <tr class="table-success">
                        <th>No</th>
                        <th>Fee (Sebelum Discount)</th>
                        <th></th>
                        <th class="text-end">Nominal</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Material (Barang) Fee</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteDetailBarangsBeforeDiscountSubtotal, 2) ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Delivery Fee</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->delivery_fee, 2) ?></td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Service Fee</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteDetailServicesBeforeDiscountDasarPengenaanPajak, 2) ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Materai Fee</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->materai_fee, 2) ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-end fw-bold">Total</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->proformaDebitNote->getproformaDebitNoteFeeTotal(), 2) ?></td>
                    </tr>
                    </tbody>

                    <!-- Tax -->
                    <tbody>
                    <tr class="table-warning">
                        <th>No</th>
                        <th>Tax</th>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <th class="text-end">Nominal</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Barang</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteDetailBarangsTotalVatNominal, 2) ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Service</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteDetailServicesTotalVatNominal, 2) ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-end fw-bold">Total</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteVatTotal, 2) ?></td>
                    </tr>


                    </tbody>

                    <!-- Discount -->
                    <tbody>
                    <tr class="table-info">
                        <th>No</th>
                        <th>Discount</th>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <th class="text-end">Nominal</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Barang</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end">
                            <?= Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteDetailBarangsDiscount, 2) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Service</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end">
                            <?= Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteDetailServicesDiscount, 2) ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-end fw-bold">Total</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end fw-bold">
                            <?= Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteDiscountTotal, 2) ?>
                        </td>
                    </tr>
                    </tbody>
                    <tbody>
                    <tr class="table-primary">
                        <td></td>
                        <td class="text-end fw-bold">Grand Total</td>
                        <td><?= $model->mataUang->singkatan ?></td>
                        <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->proformaDebitNote->proformaDebitNoteGrandTotal, 2) ?></td>
                    </tr>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <div class="card bg-transparent">

        <div class="card-body border-bottom fw-bold">
            <i class="bi bi-file-pdf"></i> Indent Delivery Receipt
        </div>

        <div class="card-body">
            <p class="font-weight-bold">
                Status: <?= $model->getGlobalStatusDeliveryReceiptInHtmlFormat() ?>
            </p>
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => new ActiveDataProvider([
                        'query'      => $model->getListDeliveryReceiptDetails(),
                        'pagination' => false,
                        'sort'       => false
                    ]),
                    'columns'      => [
                        [
                            'class' => SerialColumn::class
                        ],
                        [
                            'class'     => DataColumn::class,
                            'attribute' => 'barangNama'
                        ],
                        [
                            'class'          => DataColumn::class,
                            'attribute'      => 'quotationBarangQuantity',
                            'header'         => 'Quotation Qty',
                            'format'         => ['decimal', 2],
                            'contentOptions' => [
                                'class' => 'text-end'
                            ]
                        ],
                        [
                            'class'          => DataColumn::class,
                            'attribute'      => 'quantity',
                            'header'         => 'Qty Dikirim',
                            'format'         => ['decimal', 2],
                            'contentOptions' => [
                                'class' => 'text-end'
                            ]
                        ],
                        [
                            'class'          => DataColumn::class,
                            'attribute'      => 'totalQuantityIndent',
                            'header'         => 'Indent',
                            'format'         => ['decimal', 2],
                            'contentOptions' => [
                                'class' => 'text-end'
                            ]
                        ],
                    ],
                    'layout'       => '{items}',
                    'rowOptions'   => function ($model, $key, $index) {
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