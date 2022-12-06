<?php

namespace app\models\search;

use app\models\LokasiBarang;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class LokasiBarangSearch extends LokasiBarang
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
    * Creates data provider instance with search query applied
    * @param array $params
    * @return ActiveDataProvider
    */
   public function search(array $params): ActiveDataProvider
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

      $query->andFilterWhere(['like', 'nama', $this->nama]);
      return $dataProvider;
   }
}