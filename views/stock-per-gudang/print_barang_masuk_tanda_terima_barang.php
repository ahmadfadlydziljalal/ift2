<?php

use app\models\TandaTerimaBarang;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\web\View;


/* @var $this View */
/* @var $model TandaTerimaBarang|null */
/* @see \app\controllers\StockPerGudangController::actionPrintBarangMasukTandaTerimaPo() */

?>

<div class="print-barang-masuk-tanda-terima">
    <p class="font-weight-bold text-center">Tanda Terima: <?= $model->nomor ?></p>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Part Number</th>
            <th>Merk</th>
            <th>Nama Barang</th>
            <th>Quantity Terima</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($model->tandaTerimaBarangDetails as $i => $tandaTerimaBarangDetail): ?>
            <tr>
                <td rowspan="2"><?= ($i + 1) ?></td>
                <td><?= $tandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->part_number ?></td>
                <td><?= $tandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->merk_part_number ?></td>
                <td><?= $tandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->nama ?></td>
                <td><?= $tandaTerimaBarangDetail->quantity_terima ?></td>
            </tr>

            <tr>
                <td colspan="4" style="padding: 1rem">
                   <?php try {
                      echo GridView::widget([
                         'dataProvider' => new ActiveDataProvider([
                            'query' => $tandaTerimaBarangDetail->getHistoryLokasiBarangs(),
                            'pagination' => false,
                            'sort' => false
                         ]),
                         'columns' => [
                            [
                               'class' => SerialColumn::class
                            ],
                            [
                               'class' => DataColumn::class,
                               'attribute' => 'card_id',
                               'value' => 'card.nama'
                            ],
                            'quantity',
                            'block',
                            'rak',
                            'tier',
                            'row',
                         ],
                         'layout' => '{items}'
                      ]);
                   } catch (Throwable $e) {
                      echo $e->getMessage();
                   } ?>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>