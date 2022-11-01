<?php

use app\models\ClaimPettyCash;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;


/* @var $this View */
/* @var $model ClaimPettyCash */

$settings = Yii::$app->settings;
?>

<div id="claim-petty-cash-print">

    <h1 class="text-center">Claim Petty Cash</h1>

    <div style="width: 100%; white-space: nowrap">

        <div class="mb-1" style=" float: left; width: 49%;">
            <div class="border-1" style="min-height: 1.6cm; max-height: 1.6cm; padding: .5em">
                To: <?= $model->vendor->nama ?><br/>
                <?= $model->vendor->alamat ?>
            </div>
        </div>

        <div class="mb-1" style=" float: right; width: 49%">
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
                </tbody>
            </table>
        </div>

    </div>

    <div style="clear: both"></div>

    <div class="mb-1" style="width: 99.9%">
        <?php echo ListView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => $model->getClaimPettyCashNotas()
            ]),
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_print_view_detail', [
                    'model' => $model,
                    'index' => $index
                ]);
            },
            'itemOptions' => [
                'class' => 'mb-3 p-0'
            ],
            'layout' => '{items}'
        ]); ?>
    </div>

    <div class="mb-1">
        <p class='font-weight-bold'>
            Total
            claim: <?= Yii::$app->formatter->currencyCode ?> <?= Yii::$app->formatter->asDecimal($model->totalClaim, 2) ?>
            <br/>
            Terbilang: <?= Yii::$app->formatter->asSpellout($model->totalClaim) ?>
        </p>
    </div>


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

                <td><?= $settings->get('claim_petty_cash.approved_by_jabatan') ?></td>
                <td><?= $settings->get('claim_petty_cash.acknowledge_by_jabatan') ?></td>
                <td><?= $settings->get('claim_petty_cash.request_jabatan') ?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="clear: both"></div>

</div>