<?php

use app\models\Card;
use app\models\search\HistoryLokasiBarangSearchPerCardWarehouseSearch;
use app\models\Status;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\web\View;


/* @var $this View */
/* @var $card Card|null */
/* @var $searchModel HistoryLokasiBarangSearchPerCardWarehouseSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'History di gudang ' . $card->nama;
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $card->nama;

?>

<div class="lokasi-barang-view d-flex flex-column gap-3">

    <h1><?= $this->title ?></h1>

   <?php try {
      echo GridView::widget(config: [
         'dataProvider' => $dataProvider,
         'filterModel' => $searchModel,
         'columns' => [
            [
               'class' => SerialColumn::class
            ],
            'nomor',
            /*[
               'class' => DataColumn::class,
               'attribute' => 'cardId',
               'header' => 'Card',
               'value' => 'card.nama',
               'filter' => Card::find()->map(Card::GET_ONLY_WAREHOUSE)
            ],*/
            [
               'class' => DataColumn::class,
               'attribute' => 'tandaTerimaBarangDetailId',
               'header' => 'Tanda Terima Barang',
               'value' => 'tandaTerimaBarangDetail.tandaTerimaBarang.nomor'
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'claimPettyCashNotaDetailId',
               'header' => 'Claim Petty Cash',
               'value' => 'claimPettyCashNotaDetail.claimPettyCashNota.claimPettyCash.nomor'
            ],
            [
               'class' => DataColumn::class,
               'attribute' => 'tipePergerakanId',
               'header' => 'Tipe',
               'value' => 'tipePergerakan.key',
               'filter' => Status::find()->map(Status::SECTION_SET_LOKASI_BARANG)
            ],
            'quantity',
            'block',
            'rak',
            'tier',
            'row',
            'catatan'
         ]
      ]);
   } catch (Throwable $e) {
      echo $e->getMessage();
   } ?>

</div>