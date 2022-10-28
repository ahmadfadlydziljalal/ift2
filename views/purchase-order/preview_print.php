<?php

use app\models\PurchaseOrder;
use app\models\PurchaseOrderDetail;
use app\models\User;
use yii\web\View;

/* @see \app\controllers\PurchaseOrderController::actionPrint() */
/* @var $this View */
/* @var $model PurchaseOrder */
/* @var $openWindowPrint int */
/** @var PurchaseOrderDetail $purchaseOrderDetail */

$settings = Yii::$app->settings;

?>
<div id="purchase-order-print">

    <h1 class="text-center">Purchase Order</h1>

    <div style="width: 100%">

        <div class="mb-1" style=" float: left; width: 45%; padding-right: 2em">
            <div class="border-1" style="min-height: 1.6cm; max-height: 1.6cm; padding: .5em">
                To: <?= $model->vendor->nama ?><br/>
                <?= $model->vendor->alamat ?>
            </div>
        </div>

        <div class="mb-1" style=" float: left; width: 51%">
            <table class="table">
                <tbody>
                <tr>
                    <td>No.</td>
                    <td>:</td>
                    <td><?= $model->nomor ?></td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td><?= Yii::$app->formatter->asDate($model->tanggal) ?></td>
                </tr>
                <tr>
                    <td>Page</td>
                    <td>:</td>
                    <td><span id="page-number"></span></td>
                </tr>
                <tr>
                    <td>Ref No.</td>
                    <td>:</td>
                    <td><?= $model->reference_number ?></td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div style="clear: both"></div>

    <div class="mb-1" style="width: 100%">
        <?php if (!empty($model->purchaseOrderDetails)) : ?>
            <table class="table table-grid-view table-bordered">
                <thead>
                <tr class="text-nowrap text-center">
                    <th class="kv-align-center kv-align-middle" style="width:50px;" data-col-seq="0">No.</th>
                    <th>Part Number</th>
                    <th>IFT Number</th>
                    <th>Merk</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Satuan</th>
                    <th class="border-end-0"></th>
                    <th class="border-start-0">Price</th>
                    <th class="border-end-0"></th>
                    <th class="border-start-0">Subtotal</th>
                </tr>
                </thead>
                <tbody>

                <?php $purchaseOrderDetail = $model->getPurchaseOrderDetails()->all(); ?>
                <?php for ($i = 0; $i <= 16; $i++) : ?>

                    <?php if (isset($purchaseOrderDetail[$i])) : ?>
                        <tr class="text-nowrap " data-key="10">

                            <td class="text-end" style="width:50px;"><?= ($i + 1) ?></td>
                            <td><?= $purchaseOrderDetail[$i]->barang->part_number ?></td>
                            <td><?= $purchaseOrderDetail[$i]->barang->ift_number ?></td>
                            <td><?= $purchaseOrderDetail[$i]->barang->merk_part_number ?></td>
                            <td><?= $purchaseOrderDetail[$i]->barang->nama ?></td>
                            <td class="text-end"><?= $purchaseOrderDetail[$i]->quantity ?></td>
                            <td class=""><?= $purchaseOrderDetail[$i]->satuan->nama ?></td>
                            <td class="border-end-0"><?= Yii::$app->formatter->currencyCode ?></td>
                            <td class="border-start-0 text-end"><?= Yii::$app->formatter->asDecimal($purchaseOrderDetail[$i]->price, 2) ?></td>
                            <td class="border-end-0"><?= Yii::$app->formatter->currencyCode ?></td>
                            <td class="border-start-0 text-end"><?= Yii::$app->formatter->asDecimal($purchaseOrderDetail[$i]->getSubtotal(), 2) ?></td>
                        </tr>
                    <?php else: ?>
                        <tr class="text-nowrap " data-key="10">
                            <td class="text-end" style="width:50px"><?= ($i + 1) ?>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="border-end-0"></td>
                            <td class="border-start-0 text-end"></td>
                            <td class="border-end-0"></td>
                            <td class="border-start-0 text-end"></td>
                        </tr>
                    <?php endif; ?>

                <?php endfor; ?>

                </tbody>
                <tbody>
                <tr>
                    <td style="width:50px;">&nbsp;</td>
                    <td colspan="6" class="border-end-0 ">
                        Terbilang: <?= Yii::$app->formatter->asSpellout($model->getSumSubTotal()) ?></td>
                    <td colspan="2" class="text-end">Total:</td>
                    <td class="border-start-0 border-end-0 text-end"><?= Yii::$app->formatter->currencyCode ?></td>
                    <td class="border-start-0  text-end"><?= Yii::$app->formatter->asDecimal($model->getSumSubTotal(), 2) ?></td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div style="clear: both"></div>

    <div class="mb-1" style="width: 100%">
        <table class="table table-grid-view table-bordered">
            <tbody>
            <tr>
                <td rowspan="3" style="width: 40%">Remarks</td>
                <td style="height: 100px">Approved By</td>
                <td>Acknowledge By</td>
                <td>Request By</td>
            </tr>

            <tr>

                <td><?= $model->approved_by ?></td>
                <td><?= $model->acknowledge_by ?></td>
                <td><?= isset($model->userKaryawan) ?
                        $model->userKaryawan['nama'] :
                        User::findOne($model->created_by)->username
                    ?>
                </td>
            </tr>
            <tr>

                <td><?= $settings->get('purchase_order.approved_by_jabatan') ?></td>
                <td><?= $settings->get('purchase_order.acknowledge_by_jabatan') ?></td>
                <td><?= $settings->get('purchase_order.request_jabatan') ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="clear: both"></div>

</div>