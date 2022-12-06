<?php


/** @var $this yii/web/View */
/** @var $model ClaimPettyCash */

/** @see \app\controllers\StockPerGudangController::actionPrintBarangMasukClaimPettyCash() */

use app\models\ClaimPettyCash;
use app\models\ClaimPettyCashNotaDetail;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;

?>


<div class="stock-per-gudang-print">
    <p class="font-weight-bold text-center"><?= $model->nomor ?></p>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Harga</th>
            </tr>
            </thead>
            <tbody>
            <?php /** @var ClaimPettyCashNotaDetail $item */
            foreach ($model->getClaimPettyCashNotaDetailsHaveStockType()->all() as $i => $item) : ?>
                <tr>
                    <td rowspan="2"><?= ($i + 1) ?></td>
                    <td><?= $item->barang->nama ?></td>
                    <td><?= $item->description ?></td>
                    <td><?= $item->quantity ?></td>
                    <td><?= $item->satuan->nama ?></td>
                    <td class="text-end"><?= $item->harga ?></td>
                </tr>
                <tr>
                    <td colspan="5">
                       <?= GridView::widget([
                          'dataProvider' => new ActiveDataProvider([
                             'query' => $item->getHistoryLokasiBarangs(),
                             'sort' => false,
                             'pagination' => false
                          ]),
                          'tableOptions' => [
                             'class' => 'table table-bordered m-0'
                          ],
                          'layout' => '{items}',
                          'columns' => [
                             [
                                'class' => SerialColumn::class
                             ],
                             [
                                'class' => DataColumn::class,
                                'attribute' => 'card_id',
                                'value' => 'card.nama'
                             ],
                             [
                                'class' => DataColumn::class,
                                'attribute' => 'tipe_pergerakan_id',
                                'value' => 'tipePergerakan.key'
                             ],
                             [
                                'class' => DataColumn::class,
                                'attribute' => 'quantity'
                             ],
                             [
                                'class' => DataColumn::class,
                                'attribute' => 'block'
                             ],
                             [
                                'class' => DataColumn::class,
                                'attribute' => 'rak'
                             ],
                             [
                                'class' => DataColumn::class,
                                'attribute' => 'tier'
                             ],
                             [
                                'class' => DataColumn::class,
                                'attribute' => 'row'
                             ],
                             [
                                'class' => DataColumn::class,
                                'attribute' => 'catatan'
                             ],
                          ]
                       ]); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>