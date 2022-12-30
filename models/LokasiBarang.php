<?php

namespace app\models;

use app\enums\TipePembelianEnum;
use yii\base\Model;
use yii\db\ActiveQuery;

class LokasiBarang extends Model
{

   public ?string $nama = '';
   public ?Card $card = null;

   /**
    * Query untuk halaman index, menampilkan card yang bertipe warehouse
    * @return active_queries\CardQuery
    */
   public function getData(): active_queries\CardQuery
   {
      return Card::find()
         ->joinWith('cardTypes')
         ->where([
            'card_type.kode' => Card::GET_ONLY_WAREHOUSE
         ]);
   }

   public function getHistoryLokasiBarangPerCard(): ActiveQuery
   {
      return HistoryLokasiBarang::find()
         ->joinWith('card')
         ->joinWith('tipePergerakan')
         ->joinWith(['tandaTerimaBarangDetail' => function ($ttbd) {
            return $ttbd->joinWith('tandaTerimaBarang');
         }])
         ->joinWith(['claimPettyCashNotaDetail' => function ($cpcnd) {
            return $cpcnd->joinWith(['claimPettyCashNota' => function ($cpcn) {
               return $cpcn->joinWith('claimPettyCash');
            }]);
         }])
         ->where(['history_lokasi_barang.card_id' => $this->card->id]);
   }


   public function getStockPerGudangCardId()
   {
      return $this->getBarang();
   }

   protected function getBarang(): active_queries\BarangQuery
   {

      return Barang::find()
         ->alias('b')
         ->select([
            'id' => 'b.id',
            'nama' => 'b.nama',
            'part_number',
            'photo_thumbnail',
            'ift_number',
            'merk_part_number',
            'satuanNama' => 's.nama',
            'initialize_stock_quantity' => 'b.initialize_stock_quantity',
         ])
         ->leftJoin(['s' => 'satuan'], 'b.default_satuan_id = s.id')
         ->where('tipe_pembelian_id = :tipePembelianId', [':tipePembelianId' => TipePembelianEnum::STOCK->value])
         ->orderBy('nama');
   }
}