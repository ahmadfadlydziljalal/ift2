<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;

class StockPerGudangByCardAsDiagramSearch extends Model
{

   public StockPerGudangByCardSearch $stockPerGudangByCardSearch;
   public StockPerGudangPerCardPerBarangSearch $stockPerGudangPerCardPerBarangSearch;


   /**
    * bypass scenarios() implementation in the parent class
    * @return array
    */
   public function scenarios(): array
   {
      return Model::scenarios();
   }

   public function search(array $params): ActiveDataProvider
   {
      $query = $this->getQuery();
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'key' => 'id',
      ]);

      $this->load($params);

      if (!$this->validate()) {
         return $dataProvider;
      }

      $query->andFilterWhere(['like', 'part_number', $this->part_number]);
      $query->andFilterWhere(['like', 'ift_number', $this->ift_number]);
      $query->andFilterWhere(['like', 'b.nama', $this->nama]);
      $query->andFilterWhere(['like', 'merk_part_number', $this->merk_part_number]);
      return $dataProvider;

   }

   /**
    * @return Query
    */
   public function getQuery(): Query
   {
      $queryStockPerGudang = $this->stockPerGudangByCardSearch->getQuery();
      $queryHistoryLokasi = $this->stockPerGudangPerCardPerBarangSearch->getQuery();

      $queryStockPerGudang->selectOption = null;

      $queryStockPerGudang
         ->select("
            
             b.id                  AS id,
             b.nama                AS nama,
             b.part_number         AS part_number,
             b.ift_number          AS ift_number,
             b.merk_part_number    AS merk_part_number,
             h.`card_id`,
             h.`block`,
             h.`rak`,
             h.`tier`,
             h.`row`,
             h.`qtyFinal`          AS `qtyHistory`,
         ")
         ->addSelect([
            'availableStock' => new Expression("
               (COALESCE(initStartProject.quantity, 0)) + (COALESCE(tandaTerimaBarangDetail.quantity, 0)) +
               (COALESCE(claimPettyCashNotaDetail.quantity, 0)) - (COALESCE(deliveryReceipt.quantity, 0)) +
               (COALESCE(transferMasuk.quantity, 0)) - (COALESCE(transferKeluar.quantity, 0))"
            )
         ])
         ->leftJoin(['h' => $queryHistoryLokasi], 'h.barang_id = b.id')
         ->addOrderBy("card_id, block");

      return (new Query())
         ->from(['result' => $queryStockPerGudang])
         ->where([
            'IS NOT', 'card_id', NULL
         ]);
   }
}