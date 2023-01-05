<?php

namespace app\models\search;

use app\models\active_queries\CardQuery;
use app\models\Card;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StockPerGudangSearch extends Model
{

   public ?string $nama = '';


   /**
    * @inheritdoc
    */
   public function scenarios(): array
   {
      // bypass scenarios() implementation in the parent class
      return Model::scenarios();
   }

   /**
    * Creates data provider instance with search query applied
    * @param array $params
    * @return ActiveDataProvider
    */
   public function search(array $params): ActiveDataProvider
   {
      $query = $this->getData();
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'key' => 'id',
      ]);

      $this->load($params);

      if (!$this->validate()) {
         return $dataProvider;
      }

      $query->andFilterWhere(['like', 'nama', $this->nama]);
      return $dataProvider;
   }

   public function getData(): CardQuery
   {
      return Card::find()
         ->joinWith('cardTypes')
         ->where([
            'card_type.kode' => Card::GET_ONLY_WAREHOUSE
         ]);
   }
}