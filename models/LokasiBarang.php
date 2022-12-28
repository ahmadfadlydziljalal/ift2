<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveQuery;

class LokasiBarang extends Model
{

   public ?string $nama = '';
   public ?Card $card = null;

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
}