<?php

namespace app\models\search;

use app\models\CardOwnEquipment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CardOwnEquipmentSearch represents the model behind the search form about `app\models\CardOwnEquipment`.
 */
class CardOwnEquipmentSearch extends CardOwnEquipment
{
   /**
    * @inheritdoc
    */
   public function rules(): array
   {
      return [
         [['id', 'card_id'], 'integer'],
         [['nama', 'lokasi', 'tanggal_produk', 'serial_number'], 'safe'],
      ];
   }

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
      $query = CardOwnEquipment::find()
         ->joinWith('card');

      $dataProvider = new ActiveDataProvider([
         'query' => $query,
      ]);

      $this->load($params);

      if (!$this->validate()) {
         // if you do not want to return any records when validation fails
         // $query->where('0=1');
         return $dataProvider;
      }

      $query->andFilterWhere([
         'id' => $this->id,
         'card_id' => $this->card_id,
         'tanggal_produk' => $this->tanggal_produk,
      ]);

      $query->andFilterWhere(['like', 'nama', $this->nama])
         ->andFilterWhere(['like', 'lokasi', $this->lokasi])
         ->andFilterWhere(['like', 'serial_number', $this->serial_number]);

      $query->addOrderBy('card.nama');
      return $dataProvider;
   }
}