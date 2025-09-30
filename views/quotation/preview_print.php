<?php


/* @var $this View */
/* @var $model Quotation */

/* @see */

use app\models\Quotation;
use yii\web\View;

?>

<div class="content-section">
    <h1 class="text-center">Quotation</h1>

    <div style="width: 100%; vertical-align: top">
        <div class="mb-1" style=" float: left; width: 55%; padding-right: 1em">
            <div class="border-1" style="min-height: 1.6cm; max-height: 3.6cm; padding: .5em">
                To: <?= $model->customer->nama ?> <br/>
                <?= nl2br($model->customer->alamat) ?>
            </div>
        </div>

        <div class="mb-1" style=" float: right; width: 41%">
            <table class="table">
                <tbody>
                <tr>
                    <td class="border-end-0">No.</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $model->nomor ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Date</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= Yii::$app->formatter->asDate($model->tanggal) ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Validity</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= Yii::$app->formatter->asDate($model->tanggal_batas_valid) ?></td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div style="clear: both"></div>

    <table class="table">
        <tbody>
        <tr>
            <td class="border-end-0">Attn 1</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?= $model->attendant_1 ?></td>

            <td class="border-end-0">Attn 2</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?= $model->attendant_2 ?></td>
        </tr>
        <tr>
            <td class="border-end-0">Phone 1</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?= $model->attendant_phone_1 ?></td>

            <td class="border-end-0">Phone 2</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?= $model->attendant_phone_2 ?></td>
        </tr>
        <tr>
            <td class="border-end-0">Email 1</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?= $model->attendant_email_1 ?></td>

            <td class="border-end-0">Email 2</td>
            <td class="border-start-0 border-end-0">:</td>
            <td class="border-start-0"><?= $model->attendant_email_2 ?></td>
        </tr>
        </tbody>
    </table>

    <br/>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th rowspan="2">Part Number</th>
            <th rowspan="2">Description of Goods</th>
            <th rowspan="2">Stock</th>
            <th rowspan="2" colspan="2">Quantity</th>
            <th>Unit Price</th>
            <th>Discount</th>
            <th>Unit Price After Discount</th>
            <th>Amount</th>
        </tr>

        <tr>
            <th><?= $model->mataUang->singkatan ?></th>
            <th>%</th>
            <th><?= $model->mataUang->singkatan ?></th>
            <th><?= $model->mataUang->singkatan ?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($model->quotationBarangs as $quotationBarang) : ?>
            <tr>
                <td><?= $quotationBarang->barang->part_number ?></td>
                <td><?= $quotationBarang->barang->nama ?></td>
                <td class="text-end"><?= $quotationBarang->stock ?></td>
                <td class="text-end"><?= $quotationBarang->quantity ?></td>
                <td><?= $quotationBarang->satuan->nama ?></td>
                <td class="text-end"><?= Yii::$app->formatter->asDecimal($quotationBarang->unit_price) ?></td>
                <td class="text-end"><?= $quotationBarang->discount ?> %</td>
                <td class="text-end"><?= Yii::$app->formatter->asDecimal($quotationBarang->unitPriceAfterDiscount) ?></td>
                <td class="text-end"><?= Yii::$app->formatter->asDecimal($quotationBarang->amount) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>

        <tfoot>
        <tr>
            <td class="border-start-0 border-end-0" colspan="4" rowspan="5">
                <span class="font-weight-bold">Note:</span><br/>
                <?= $model->catatan_quotation_barang ?>
            </td>
            <td colspan="2">SubTotal</td>
            <td></td>
            <td></td>
            <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationBarangsSubtotal) ?></td>
        </tr>
        <tr>
            <td colspan="2">Delivery Fee</td>
            <td></td>
            <td></td>
            <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->delivery_fee) ?></td>
        </tr>
        <tr>

            <td colspan="2">DPP</td>
            <td></td>
            <td></td>
            <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationBarangsDasarPengenaanPajak) ?></td>
        </tr>

        <tr>

            <td colspan="2">PPN</td>
            <td class="text-end"><?= $model->vatPercentageLabel ?> </td>
            <td></td>
            <td class="text-end"><?= Yii::$app->formatter->asDecimal(round($model->quotationBarangsTotalVatNominal)) ?></td>
        </tr>

        <tr>
            <td colspan="2" class="font-weight-bold">Total (A)</td>
            <td class="text-end"></td>
            <td></td>
            <td class="text-end font-weight-bold"><?= Yii::$app->formatter->asDecimal(round($model->quotationBarangsTotal)) ?></td>
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
                <th rowspan="2" colspan="2">Quantity</th>
                <th>Rate</th>
                <th>Discount</th>
                <th>Rate After Discount</th>
                <th>Amount</th>
            </tr>
            <tr>
                <th><?= $model->mataUang->singkatan ?></th>
                <th>%</th>
                <th><?= $model->mataUang->singkatan ?></th>
                <th><?= $model->mataUang->singkatan ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($model->quotationServices as $key => $quotationService) : ?>

                <tr>
                    <td><?= ($key + 1) ?></td>
                    <td style="min-width: 17rem"><?= $quotationService->job_description ?></td>
                    <td class="text-end"><?= $quotationService->quantity ?></td>
                    <td class="text-end"><?= $quotationService->satuan->nama ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($quotationService->rate) ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($quotationService->discount) ?> %</td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($quotationService->rateAfterDiscount) ?></td>
                    <td class="text-end"><?= Yii::$app->formatter->asDecimal($quotationService->amount) ?></td>
                </tr>

            <?php endforeach; ?>
            </tbody>

            <tfoot>
            <tr>

                <td colspan="4" rowspan="3" class="border-start-0 border-end-0">
                    <span class="font-weight-bold">Note:</span><br/>
                    <?= $model->catatan_quotation_service ?>
                </td>
                <td>DPP</td>
                <td></td>
                <td></td>
                <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationServicesDasarPengenaanPajak) ?></td>
            </tr>

            <tr>

                <td>PPN</td>
                <td class="text-end"><?= $model->vatPercentageLabel ?></td>
                <td></td>
                <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationServicesTotalVatNominal) ?></td>
            </tr>

            <tr>

                <td style="width: 6em" class="font-weight-bold">TOTAL (B)</td>
                <td></td>
                <td></td>
                <td class="text-end font-weight-bold"><?= Yii::$app->formatter->asDecimal($model->quotationServicesTotal) ?></td>
            </tr>

            </tfoot>
        </table>
    </div>

    <div class="mt-1" style="width: 100%; vertical-align: top">

        <div class="mb-1" style=" float: left; width: 50%; padding-right: 2em">
            <div class="border-1" style="min-height: 1.6cm; max-height: 3.6cm; padding: .5em">
                <span>Bank Account Details</span> <br/>
                <?= nl2br($model->rekening->atas_nama) ?>
            </div>
        </div>

        <div class="mb-1" style=" float: right; width: 45%">
            <table class="table">
                <tbody>
                <tr>
                    <td class="border-end-0 font-weight-bold">Materai (C)</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0 border-end-0 font-weight-bold"><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end border-start-0 font-weight-bold"><?= Yii::$app->formatter->asDecimal($model->materai_fee) ?></td>
                </tr>
                <tr>
                    <td class="border-end-0 font-weight-bold">Grand Total (A+B+C)</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0 border-end-0 font-weight-bold"><?= $model->mataUang->singkatan ?></td>
                    <td class="text-end border-start-0 font-weight-bold"><?= Yii::$app->formatter->asDecimal(round($model->quotationGrandTotal)) ?></td>
                </tr>
                </tbody>
            </table>

            <?php if ($model->quotationFormJob) : ?>
                <div class="p0 mt-2">

                    <span>
                        <strong class="font-weight-bold">Unit: </strong>
                        <?php
                        if ($model->quotationFormJob->cardOwnEquipment) {
                            echo $model->quotationFormJob->cardOwnEquipmentLabel;
                        }
                        ?>
                    </span>

                </div>
            <?php endif; ?>

        </div>

    </div>

    <div style="clear: both"></div>

    <?php if ($model->quotationTermAndConditions) : ?>
        <div class="mt-5">
            <span class="font-weight-bold">Term and Condition</span> <br/>
            <table class="table">
                <tbody>
                <?php foreach ($model->quotationTermAndConditions as $k => $termAndCondition) : ?>
                    <tr>
                        <td><?= ($k + 1) ?></td>
                        <td class="text-nowrap"><?= $termAndCondition->term_and_condition ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>

    <table class="table table-borderless mt-1" style="page-break-inside: avoid">
        <thead>
        <tr>
            <td style="width: 50%" class="text-center">Signature</td>
            <td style="width: 50%" class="text-center">Customer Signature</td>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td class="text-center" style="height: 6em"><?= Yii::$app->settings->get('site.companyClient') ?></td>
            <td class="text-center"><?= $model->customer->nama ?></td>
        </tr>

        <tr>
            <td class="text-center"><?= $model->signatureOrangKantor->nama ?></td>
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