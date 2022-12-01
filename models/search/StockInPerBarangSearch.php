<?php

namespace app\models\search;

use app\models\StockInPerBarang;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StockInPerBarangSearch extends StockInPerBarang
{

   /**
    * @inheritdoc
    */
   public function scenarios(): array
   {
      // bypass scenarios() implementation in the parent class
      return Model::scenarios();
   }

   /**
    * @param array $params
    * @param int $id BarangId
    * @return ActiveDataProvider
    */
   public function search(array $params, int $id): ActiveDataProvider
   {
      $query = parent::getData();
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'key' => 'id',
      ]);
      $this->load($params);

      if (!$this->validate()) {
         return $dataProvider;
      }

      return $dataProvider;

   }
}