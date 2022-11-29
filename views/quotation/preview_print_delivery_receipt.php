<?php


/* @var $this View */
/* @var $model QuotationDeliveryReceipt */

/* @var $quotation Quotation */

use app\models\Quotation;
use app\models\QuotationDeliveryReceipt;
use yii\web\View;

?>

<div class="quotation-delivery-receipt content-section">

    <h1 class="text-center">Delivery Receipt</h1>

    <div style="width: 100%; vertical-align: top">
        <div class="mb-1" style=" float: left; width: 46%">
            <table class="table">
                <tbody>
                <tr>
                    <td class="border-end-0">To</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $quotation->customer->nama ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Address</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $quotation->customer->alamat ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Attn</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0">
                       <?php
                       array_filter($quotation->customer->cardPersonInCharges, function ($element) {
                          echo !empty($element->nama)
                             ? $element->nama . '; '
                             : '';
                       })
                       ?>
                    </td>
                </tr>
                <tr>
                    <td class="border-end-0">Phone</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0">
                       <?php
                       array_filter($quotation->customer->cardPersonInCharges, function ($element) {
                          echo !empty($element->telepon)
                             ? $element->telepon . '; '
                             : '';
                       })
                       ?>
                    </td>
                </tr>
                <tr>
                    <td class="border-end-0">Email</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0">
                       <?php
                       array_filter($quotation->customer->cardPersonInCharges, function ($element) {
                          echo !empty($element->email)
                             ? $element->email . '; '
                             : '';
                       })
                       ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="mb-1" style=" float: right; width: 52%">
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
                    <td class="border-end-0">P.O Number</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $model->purchase_order_number ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Quotation</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $quotation->nomor ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Checker</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $model->checker ?></td>
                </tr>
                <tr>
                    <td class="border-end-0">Vehicle</td>
                    <td class="border-start-0 border-end-0">:</td>
                    <td class="border-start-0"><?= $model->vehicle ?></td>
                </tr>
                </tbody>
            </table>
            <p class="font-weight-bold">
                Quotation Status: <?= $quotation->getGlobalStatusDeliveryReceiptInHtmlFormat() ?>
            </p>
        </div>
    </div>

    <div style="clear: both"></div>

    <table class="table mt-1">
        <thead>
        <tr>
            <td style="width: 2px">NO</td>
            <td>Mark | Part Number</td>
            <td>Description</td>
            <td>Quotation</td>
            <td>Quantity</td>
            <td>UOM</td>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($model->quotationDeliveryReceiptDetails as $key => $detail) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $detail->quotationBarang->barang->merk_part_number ?>
                    | <?= $detail->quotationBarang->barang->part_number ?>
                </td>
                <td>
                   <?= $detail->quotationBarang->barang->nama ?>
                   <?= !empty($detail->quotationBarang->barang->keterangan)
                      ? (' - ' . $detail->quotationBarang->barang->keterangan)
                      : ''
                   ?>
                </td>
                <td class="text-end">
                   <?= $detail->quotationBarang->quantity ?>
                </td>
                <td class="text-end">
                   <?= $detail->quantity ?>
                </td>
                <td class="text-end">
                   <?= $detail->quotationBarang->satuan->nama ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p>
        Remarks:
    </p>

   <?php
   $quotationDeliveryReceipts = $quotation->quotationDeliveryReceipts;
   if (count($quotationDeliveryReceipts) > 1) : ?>
    <p>By Sistem: Delivery Receipt diangsur beberapa kali:<br/>
       <?php
       /** @var QuotationDeliveryReceipt $quotationDeliveryReceipt */
       foreach ($quotationDeliveryReceipts as $quotationDeliveryReceipt) {
          $string = $quotationDeliveryReceipt->nomor;

          if ($quotationDeliveryReceipt->id == $model->id) {
             $string .= '<strong class="font-weight-bold"> (Dokumen Ini)</strong>';
          }

          echo $string . '<br/>';
       }
       ?>
       <?php endif ?>
       <?= $model->remarks ?>
    </p>

    <div style="width: 100%; position:fixed; bottom: 0; left: 0">
        <table class="table">
            <tbody>
            <tr>
                <td class="text-center" style="height: 6em"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
            <tr>
                <td style="width: 25%" class="text-center">Sender</td>
                <td style="width: 25%" class="text-center">Security</td>
                <td style="width: 25%" class="text-center">Admin + Sales</td>
                <td style="width: 25%" class="text-center">Customer</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>