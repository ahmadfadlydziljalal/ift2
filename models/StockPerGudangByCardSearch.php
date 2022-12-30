<?php

namespace app\models;

class StockPerGudangByCardSearch extends LokasiBarang
{

   public function search(mixed $queryParams)
   {
      $query = parent::getStockPerGudangCardId();
      return $query->all();
   }
}