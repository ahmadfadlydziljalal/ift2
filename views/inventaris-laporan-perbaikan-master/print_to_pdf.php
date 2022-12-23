<?php

use app\models\InventarisLaporanPerbaikanMaster;
use app\models\User;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $model InventarisLaporanPerbaikanMaster */
/* @see \app\controllers\InventarisLaporanPerbaikanMasterController::actionPrintToPdf() */

?>

<div id="inventaris-laporan-perbaikan-master-print">

    <h1 class="text-center">EQUIPMENT/TOOL REPAIR REQUEST</h1>


    <div style="width: 100%; white-space: nowrap">

        <div class="mb-1" style=" float: left; width: 49%;">
            <div class="border-1" style="min-height: 1.6cm; max-height: 1.6cm; padding: .5em">
                To: <?= $model->card->nama ?><br/>
               <?= $model->card->alamat ?>
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
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td><?= ucfirst($model->status->key) ?></td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <div style="clear: both"></div>

   <?php try {


      echo !empty($model->inventarisLaporanPerbaikanDetails) ?
         GridView::widget([
            'dataProvider' => new ArrayDataProvider([
               'allModels' => $model->inventarisLaporanPerbaikanDetails
            ]),
            'layout' => '{items}',
            'showPageSummary' => true,
            'columns' => [
               // [
               // 'class'=>'\kartik\grid\DataColumn',
               // 'attribute'=>'id',
               // ],
               // [
               // 'class'=>'\kartik\grid\DataColumn',
               // 'attribute'=>'inventaris_laporan_perbaikan_master_id',
               // ],
               [
                  'class' => SerialColumn::class,
                  'header' => 'No.',
               ],
               [
                  'class' => '\kartik\grid\DataColumn',
                  'attribute' => 'inventaris_id',
                  'value' => 'inventaris.kode_inventaris',
                  'pageSummary' => true,
                  'pageSummaryFormat' => 'raw',
                  'pageSummaryFunc' => function () {
                     return Html::tag('strong', "Total: ");
                  },
                  'pageSummaryOptions' => [
                     'class' => 'text-end',
                     'colspan' => 5
                  ]
               ],
               [
                  'class' => '\kartik\grid\DataColumn',
                  'attribute' => 'kondisi_id',
                  'value' => 'kondisi.key'
               ],
               [
                  'class' => '\kartik\grid\DataColumn',
                  'attribute' => 'last_location_id',
                  'value' => 'lastLocation.nama'
               ],
               [
                  'class' => '\kartik\grid\DataColumn',
                  'attribute' => 'last_repaired',
                  'format' => 'datetime',
               ],
               [
                  'class' => '\kartik\grid\DataColumn',
                  'attribute' => 'remarks',
                  'format' => 'nText',

               ],
               [
                  'class' => '\kartik\grid\DataColumn',
                  'attribute' => 'estimated_price',
                  'contentOptions' => [
                     'class' => 'text-end'
                  ],
                  'format' => ['decimal', 2],
                  'pageSummary' => true,
                  'pageSummaryOptions' => [
                     'class' => 'text-end'
                  ]

               ],
            ]
         ]) :
         Html::tag("p", 'Inventaris Laporan Perbaikan Detail tidak tersedia', [
            'class' => 'text-warning font-weight-bold p-3'
         ]);
   } catch (Exception $e) {
      echo $e->getMessage();
   } catch (Throwable $e) {
      echo $e->getMessage();
   }
   ?>
    <br/>
    Total :

    <div class="mb-1" style="width: 100%">
        <table class="table table-grid-view table-bordered">
            <tbody>
            <tr>
                <td rowspan="3" style="width: 40%">Comment</td>
                <td class="text-center" style="height: 100px">Approved By</td>
                <td class="text-center">Acknowledge By</td>
                <td class="text-center">Created By</td>
            </tr>

            <tr>
                <td class="text-center"><?= $model->approvedBy->nama ?></td>
                <td class="text-center"><?= $model->knownBy->nama ?></td>
                <td class="text-center"><?= isset($model->userKaryawan) ?
                      $model->userKaryawan['nama'] :
                      User::findOne($model->created_by)->username
                   ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">Direktur</td>
                <td class="text-center">Manager</td>
                <td class="text-center">Workshop</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div style="clear: both"></div>
</div>