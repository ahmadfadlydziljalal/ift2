<?php

use app\models\Quotation;
use app\models\QuotationFormJob;
use yii\web\View;


/* @var $this View */
/* @var $quotation Quotation */
/* @var $quotationFormJob QuotationFormJob */
/* @see \app\controllers\QuotationController::actionPrintFormJob() */
?>


<div class="content-section">
    <h1 class="text-center">Form Jobs</h1>

    <div style="width: 100%; vertical-align: top">

        <div class="mb-1" style=" float: left; width: 46%">
            <table class="table">
                <tbody>
                <tr>
                    <td class="border-end-0">No Service</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $quotationFormJob->nomor ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">No SPK</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $quotationFormJob->getNomorSuratPerintahKerja() ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">No Quotation</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $quotationFormJob->quotation->nomor ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Date</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= Yii::$app->formatter->asDate($quotationFormJob->tanggal) ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">P.I.C</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $quotationFormJob->person_in_charge ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Issue</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $quotationFormJob->issue ?></td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-1" style=" float: right; width: 52%">
            <table class="table">
                <tbody>
                <tr>
                    <td class="border-end-0">Customer</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0">
                        <?= $quotationFormJob->quotation->customer->nama ?>
                    </td>
                </tr>

                <tr>
                    <td class="border-end-0">No Unit</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0">
                        <?= $quotationFormJob->cardOwnEquipment?->nomor_unit ?>
                    </td>
                </tr>

                <tr>
                    <td class="border-end-0">Merk / Type</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0">
                        <?= $quotationFormJob->cardOwnEquipment?->merk ?>
                        / <?= $quotationFormJob->cardOwnEquipment?->nama ?>
                    </td>
                </tr>
                <tr>
                    <td class="border-end-0">H M</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $quotationFormJob->hour_meter ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Product No</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $quotationFormJob->cardOwnEquipment?->serial_number ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Mekanik</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= implode('; ', $quotationFormJob->namaMekaniks) ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div style="clear: both"></div>

    <div style="width: 100%; vertical-align: top">
        <div class="mb-1" style=" float: left; width: 46%;">

            <table class="table mt-1">

                <thead>
                <tr>
                    <td colspan="2" class="text-start">Jobs</td>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($quotationFormJob->getQuotationFormJobJobs()->joinWith(['satuan'])->each() as $keyService => $quotationService) : ?>
                    <tr>
                        <td class="text-end" style="width: 2em"><?= ($keyService + 1) ?>.</td>
                        <td><?= $quotationService->nama ?></td>
                        <td class="text-end" style="width: 4em"> <?= $quotationService->quantity ?></td>
                        <td><?= $quotationService->satuan->nama ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>
        <div class="mb-1" style=" float: right; width: 52%;">
            <table class="table mt-1">

                <thead>


                <tr>
                    <td colspan="2" class="text-start">Spare Part Estimation</td>
                </tr>


                </thead>

                <tbody>
                <?php /** @var app\models\QuotationFormJobSparePart $sparePart */
                foreach ($quotationFormJob->getQuotationFormJobSpareParts()->joinWith(['satuan', 'barang'])->each() as $keySparePart => $sparePart) : ?>
                    <tr>
                        <td class="text-end" style="width: 2em"><?= ($keySparePart + 1) ?>.</td>
                        <td><?= $sparePart->barang->nama ?></td>
                        <td class="text-end" style="width: 4em"><?= $sparePart->quantity ?></td>
                        <td><?= $sparePart->satuan->nama ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

    <div style="clear: both"></div>

    <p>
        Remarks:<br/>
        <?= $quotationFormJob->remarks ?>
    </p>

    <div style="color:red;width: 100%; position:fixed; bottom: 0; left: 0">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <th style="width: 20%" class="text-center"><span class="fw-bold">Admin</span></th>
                <th style="width: 20%" class="text-center">SPV</th>
                <th style="width: 20%" class="text-center">Chief</th>
                <th style="width: 20%" class="text-center">Mechanic</th>
                <th style="width: 20%" class="text-center">Customer</th>
            </tr>

            <tr>
                <td class="text-center" style="height: 6em"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
            </tbody>
        </table>
    </div>


</div>