<?php

use app\models\ProformaInvoice;
use app\models\Quotation;
use yii\web\View;


/* @var $this View */
/* @var $quotation Quotation */
/* @var $model ProformaInvoice */
/* @see \app\controllers\QuotationController::actionPrintProformaInvoice() */

?>

<div class="content-section">
    <h1 class="text-center">Proforma Invoice</h1>

    <div style="width: 100%; vertical-align: top">

        <div class="mb-1" style=" float: left; width: 55%; padding-right: 1em">

            <table class="table">
                <tbody>
                <tr>
                    <td class="border-end-0">Quotation No.</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?php echo $quotation->nomor ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Invoice No</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?php echo $model->nomor ?></td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-1" style=" float: right; width: 41%">
            <table class="table">
                <tbody>

                <tr>
                    <td class="border-end-0">Quotation`s Date</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?php echo Yii::$app->formatter->asDate($quotation->tanggal) ?></td>
                </tr>

                <tr>
                    <td class="border-end-0">Invoice`s Date</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?php echo Yii::$app->formatter->asDate($model->tanggal) ?></td>
                </tr>

                </tbody>
            </table>
        </div>

    </div>
    <div style="clear: both"></div>

    <div style="width: 100%; vertical-align: top">

        <div style=" float: left; width: 55%; padding-right: 2em">
            <div class="border-1" style="min-height: 1.6cm; max-height: 3.6cm; padding: .5em">
                To: <?php echo $quotation->customer->nama ?> <br/>
               <?php echo nl2br($quotation->customer->alamat) ?>
            </div>
        </div>

        <div class="mb-1" style=" float: right; width: 41%">

        </div>

    </div>
    <div style="clear: both"></div>

    <table class="table">
        <tbody>
        <tr>
            <td class="border-end-0">Attn 1</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?php echo $quotation->attendant_1 ?></td>

            <td class="border-end-0">Attn 2</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?php echo $quotation->attendant_2 ?></td>
        </tr>
        <tr>
            <td class="border-end-0">Phone 1</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?php echo $quotation->attendant_phone_1 ?></td>

            <td class="border-end-0">Phone 2</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?php echo $quotation->attendant_phone_2 ?></td>
        </tr>
        <tr>
            <td class="border-end-0">Email 1</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?php echo $quotation->attendant_email_1 ?></td>

            <td class="border-end-0">Email 2</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?php echo !empty($quotation->attendant_email_2) ? $quotation->attendant_email_2 : ' - ' ?></td>
        </tr>
        </tbody>
    </table>

    <br/>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th rowspan="2">Part Number</th>
            <th rowspan="2" class="text-nowrap">Description of Goods</th>
            <th rowspan="2">Stock</th>
            <th rowspan="2" colspan="2">Quantity</th>
            <th>Unit Price</th>
            <th>Discount</th>
            <th>Unit Price After Discount</th>
            <th>Amount</th>
        </tr>

        <tr>
            <th><?php echo $quotation->mataUang->singkatan ?></th>
            <th>%</th>
            <th><?php echo $quotation->mataUang->singkatan ?></th>
            <th><?php echo $quotation->mataUang->singkatan ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($model->proformaInvoiceDetailBarangs as $proformaInvoiceDetailBarang) : ?>
            <tr>
                <td><?php echo $proformaInvoiceDetailBarang->barang->part_number ?></td>
                <td><?php echo $proformaInvoiceDetailBarang->barang->nama ?></td>
                <td class="text-end"><?php echo $proformaInvoiceDetailBarang->stock ?></td>
                <td class="text-end"><?php echo $proformaInvoiceDetailBarang->quantity ?></td>
                <td><?php echo $proformaInvoiceDetailBarang->satuan->nama ?></td>
                <td class="text-end"><?php echo Yii::$app->formatter->asDecimal($proformaInvoiceDetailBarang->unit_price) ?></td>
                <td class="text-end"><?php echo $proformaInvoiceDetailBarang->discount ?> %</td>
                <td class="text-end"><?php echo Yii::$app->formatter->asDecimal($proformaInvoiceDetailBarang->unitPriceAfterDiscount) ?></td>
                <td class="text-end"><?php echo Yii::$app->formatter->asDecimal($proformaInvoiceDetailBarang->amount) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>

        <tfoot>
        <tr>
            <td class="border-start-0 border-end-0" colspan="4" rowspan="5">
                <span class="font-weight-bold">Note</span>: <br/>
               <?php echo $model->quotation->catatan_quotation_barang ?>
            </td>

            <td colspan="2">SubTotal</td>
            <td></td>
            <td></td>
            <td class="text-end">
               <?php echo Yii::$app->formatter->asDecimal($model->proformaInvoiceDetailBarangsSubtotal) ?>
            </td>
        </tr>
        <tr>

            <td colspan="2">Delivery Fee</td>
            <td></td>
            <td></td>
            <td class="text-end">
               <?php echo Yii::$app->formatter->asDecimal($model->quotation->delivery_fee) ?>
            </td>
        </tr>
        <tr>

            <td colspan="2">DPP</td>
            <td></td>
            <td></td>
            <td class="text-end">
               <?php echo Yii::$app->formatter->asDecimal($model->proformaInvoiceDetailBarangsDasarPengenaanPajak) ?>
            </td>
        </tr>

        <tr>

            <td colspan="2">PPN</td>
            <td class="text-end"><?php echo $quotation->vatPercentageLabel ?> </td>
            <td></td>
            <td class="text-end">
               <?php echo Yii::$app->formatter->asDecimal(round($model->proformaInvoiceDetailBarangsTotalVatNominal)) ?>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="font-weight-bold">Total
                (A)
            </td>
            <td></td>
            <td></td>
            <td class="text-end font-weight-bold">
               <?php echo Yii::$app->formatter->asDecimal($model->proformaInvoiceDetailBarangsTotal, 2) ?>
            </td>


        </tr>

        </tfoot>
    </table>

    <div class="mt-1">
        <span class="font-weight-bold">Service</span>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Job Description</th>
                <th rowspan="2">Hours</th>
                <th class="text-nowrap">Rate / Hours</th>
                <th>Discount</th>
                <th>Rate / Hours After Discount</th>
                <th>Amount</th>
            </tr>
            <tr>
                <th><?= $quotation->mataUang->singkatan ?></th>
                <th>%</th>
                <th><?= $quotation->mataUang->singkatan ?></th>
                <th><?= $quotation->mataUang->singkatan ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model->proformaInvoiceDetailServices as $key => $proformaInvoiceDetailService) : ?>

                <tr>
                    <td><?= ($key + 1) ?></td>
                    <td style="min-width: 17rem"><?= $proformaInvoiceDetailService->job_description ?></td>
                    <td class="text-end"><?= $proformaInvoiceDetailService->hours ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($proformaInvoiceDetailService->rate_per_hour) ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($proformaInvoiceDetailService->discount) ?>
                        %
                    </td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($proformaInvoiceDetailService->ratePerHourAfterDiscount) ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($proformaInvoiceDetailService->amount) ?></td>
                </tr>

            <?php endforeach; ?>
            </tbody>

            <tfoot>
            <tr>

                <td rowspan="3" colspan="3" class="border-start-0 border-end-0">
                    <span class="font-weight-bold">Note</span><br/>
                   <?= $quotation->catatan_quotation_service ?>
                </td>

                <td>DPP</td>
                <td></td>
                <td></td>
                <td class="text-end">
                   <?= Yii::$app->formatter->asDecimal($model->proformaInvoiceDetailServicesDasarPengenaanPajak) ?>
                </td>
            </tr>

            <tr>

                <td>PPN</td>
                <td class="text-end"><?= $quotation->vatPercentageLabel ?></td>
                <td></td>
                <td class="text-end">
                   <?= Yii::$app->formatter->asDecimal($model->proformaInvoiceDetailServicesTotalVatNominal) ?>
                </td>
            </tr>

            <tr>

                <td style="width: 6em" class="font-weight-bold">TOTAL (B)</td>
                <td></td>
                <td></td>
                <td class="text-end font-weight-bold">
                   <?= Yii::$app->formatter->asDecimal($model->proformaInvoiceDetailServicesTotal) ?>
                </td>
            </tr>

            </tfoot>
        </table>
    </div>

    <div class="mt-1" style="width: 100%; vertical-align: top">

        <div class="mb-1" style=" float: left; width: 50%; padding-right: 2em">
            <div class="border-1" style="min-height: 1.6cm; max-height: 3.6cm; padding: .5em">
                <span>Bank Account Details</span> <br/>
               <?= nl2br($quotation->rekening->atas_nama) ?>
            </div>
        </div>

        <div class="mb-1" style=" float: right; width: 45%">
            <table class="table">
                <tbody>
                <tr>
                    <td class="border-end-0 font-weight-bold">Materai (C)</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0 border-end-0 font-weight-bold"><?= $quotation->mataUang->singkatan ?></td>
                    <td class="text-end border-start-0 font-weight-bold"><?= Yii::$app->formatter->asDecimal($quotation->materai_fee) ?></td>
                </tr>
                <tr>
                    <td class="border-end-0 font-weight-bold">Grand Total (A+B+C)</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0 border-end-0 font-weight-bold"><?= $quotation->mataUang->singkatan ?></td>
                    <td class="text-end border-start-0 font-weight-bold">
                       <?php echo Yii::$app->formatter->asDecimal(round($model->proformaInvoiceGrandTotal)) ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div style="clear: both"></div>

    <table class="table table-borderless mt-1" style="page-break-inside: avoid">
        <thead>
        <tr>

            <td style="width: 50%" class="text-center"></td>
            <td style="width: 50%" class="text-center">Signature</td>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td>
                PPP23 sebesar:
               <?= $model->getPph23Label() ?> =
               <?= $quotation->mataUang->singkatan ?> <?= Yii::$app->formatter->asDecimal($model->getPph23Nominal(), 2) ?>
                <br/>
                Penerimaan sebesar:
               <?= $quotation->mataUang->singkatan ?> <?= Yii::$app->formatter->asDecimal($model->getPenerimaan(), 2) ?>
            </td>
            <td class="text-center" style="height: 6em"></td>
        </tr>

        <tr>
            <td class="text-center"></td>
            <td class="text-center">
                (
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                )
            </td>
        </tr>
        </tbody>
    </table>
</div>