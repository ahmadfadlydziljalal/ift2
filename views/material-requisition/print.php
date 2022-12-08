<?php

/* @see \app\controllers\MaterialRequisitionController::actionPrint() */
/* @var $this View */

/* @var $model MaterialRequisition */

use app\models\MaterialRequisition;
use app\models\User;
use yii\web\View;

$settings = Yii::$app->settings;
?>

<div id="material-requisition-print">

    <h1 class="text-center">Material Requisition</h1>

    <div style="width: 100%; white-space: nowrap">

        <div class="mb-1" style=" float: left; width: 49%;">
            <div class="border-1" style="min-height: 1.6cm; max-height: 1.6cm; padding: .5em">
                To: <?= $model->vendor->nama ?><br/>
               <?= nl2br($model->vendor->alamat) ?>
            </div>
        </div>

        <div class="mb-1" style=" float: right; width: 49%">
            <table class="table">
                <tbody>
                <tr>
                    <td class="border-end-0">No.</td>
                    <td class="border-0">:</td>
                    <td class="border-start-0"><?= $model->nomor ?></td>
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

    <div class="mb-1" style="width: 100%">
       <?= $this->render('_item', ['model' => $model]) ?>
    </div>

    <div style="clear: both"></div>

    <div class="mb-1" style="width: 100%">
        <table class="table table-grid-view table-bordered">
            <tbody>
            <tr>
                <td class="text-center text-nowrap" rowspan="3" style="width: 40%">Remarks</td>
                <td class="text-center text-nowrap" style="height: 100px">Approved By</td>
                <td class="text-center text-nowrap">Acknowledge By</td>
                <td class="text-center text-nowrap">Request By</td>
            </tr>

            <tr>
                <td class="text-center text-nowrap"><?= $model->approvedBy->nama ?></td>
                <td class="text-center text-nowrap"><?= $model->acknowledgeBy->nama ?></td>
                <td class="text-center text-nowrap"><?= isset($model->userKaryawan) ?
                      $model->userKaryawan['nama'] :
                      User::findOne($model->created_by)->username
                   ?>
                </td>
            </tr>
            <tr>
                <td class="text-center text-nowrap"><?= $settings->get('material_requisition.approved_by_jabatan') ?></td>
                <td class="text-center text-nowrap"><?= $settings->get('material_requisition.acknowledge_by_jabatan') ?></td>
                <td class="text-center text-nowrap"><?= $settings->get('material_requisition.request_jabatan') ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="clear: both"></div>

</div>