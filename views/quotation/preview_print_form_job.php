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
                    <td class="border-end-0">No Unit</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0">
                       <?= !empty($quotationFormJob->cardOwnEquipment)
                          ? $quotationFormJob->cardOwnEquipment->serial_number
                          : ""
                       ?>
                    </td>
                </tr>
                <tr>
                    <td class="border-end-0">Customer</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0">
                       <?= !empty($quotationFormJob->cardOwnEquipment)
                          ? $quotationFormJob->namaMekanik
                          : ""
                       ?>
                    </td>
                </tr>
                <tr>
                    <td class="border-end-0">Merk / Type</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0">
                       <?= !empty($quotationFormJob->cardOwnEquipment)
                          ? $quotationFormJob->cardOwnEquipment->nama
                          : ""
                       ?>
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
                    <td class="border-start-0"></td>
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
                <tr>
                    <td colspan="2" class="text-start">Quotation No: <?= $quotation->nomor ?></td>
                </tr>

                </thead>

                <tbody>
                <?php foreach ($quotation->quotationServices as $keyService => $quotationService) : ?>
                    <tr>
                        <td class="text-end"><?= ($keyService + 1) ?></td>
                        <td><?= $quotationService->job_description ?></td>
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
                    <td rowspan="2">Quantity</td>
                </tr>

                <tr>
                    <td colspan="2" class="text-start text-nowrap" style="vertical-align: middle">Quotation
                        No: <?= $quotation->nomor ?></td>
                </tr>

                </thead>

                <tbody>
                <?php foreach ($quotation->quotationBarangs as $keyBarang => $quotationBarang) : ?>
                    <tr>
                        <td class="text-end"><?= ($keyBarang + 1) ?></td>
                        <td><?= $quotationBarang->barang->nama ?></td>
                        <td class="text-end"><?= $quotationBarang->quantity ?></td>
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
                <td style="width: 20%" class="text-center">Admin</td>
                <td style="width: 20%" class="text-center">Inventory</td>
                <td style="width: 20%" class="text-center">Workshop Head</td>
                <td style="width: 20%" class="text-center">Mechanic</td>
                <td style="width: 20%" class="text-center">Customer</td>
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