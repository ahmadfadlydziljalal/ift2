<?php

/* @see \app\controllers\MaterialRequisitionController::actionPrintPenawaran() */
/* @var $this View */

/* @var $model MaterialRequisition */

use app\models\MaterialRequisition;
use app\models\User;
use yii\web\View;

$settings = Yii::$app->settings;
?>

<div id="material-requisition-print">

    <h1 class="text-center">Penawaran Harga - Material Requisition</h1>

    <div style="width: 100%; white-space: nowrap">

        <div class="" style=" float: left; width: 49%;">
            <div class="border-1" style="min-height: 1.6cm; max-height: 1.6cm; padding: .5em">
                To: <?= $model->vendor->nama ?><br/>
               <?= nl2br($model->vendor->alamat) ?>
            </div>
        </div>

        <div class="" style=" float: right; width: 49%">
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
                <!--<tr>
                    <td>Page</td>
                    <td>:</td>
                    <td><span id="page-number"></span></td>
                </tr>-->
                </tbody>
            </table>
        </div>

    </div>

    <div style="clear: both"></div>

    <div class="" style="width: 100%">
        <p>Silahkan centang barang yang di approve</p>
       <?= $this->render('_item_penawaran_harga', ['model' => $model]) ?>
    </div>

    <div style="clear: both"></div>

    <div class="mb-1" style="width: 100%">
        <table class="table table-grid-view table-bordered">
            <tbody>
            <tr>
                <td class="text-nowrap text-center" rowspan="3" style="width: 40%">Remarks</td>
                <td class="text-nowrap text-center" style="height: 100px">Approved By</td>
                <td class="text-nowrap text-center">Acknowledge By</td>
                <td class="text-nowrap text-center">Request By</td>
            </tr>

            <tr>
                <td class="text-nowrap text-center"><?= $model->approvedBy->nama ?></td>
                <td class="text-nowrap text-center"><?= $model->acknowledgeBy->nama ?></td>
                <td class="text-nowrap text-center"><?= isset($model->userKaryawan) ?
                      $model->userKaryawan['nama'] :
                      User::findOne($model->created_by)->username
                   ?>
                </td>
            </tr>
            <tr>
                <td class="text-nowrap text-center"><?= $settings->get('material_requisition.approved_by_jabatan') ?></td>
                <td class="text-nowrap text-center"><?= $settings->get('material_requisition.acknowledge_by_jabatan') ?></td>
                <td class="text-nowrap text-center"><?= $settings->get('material_requisition.request_jabatan') ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="clear: both"></div>

</div>