<?php

namespace app\models\search;

use app\enums\PotensiCardOwnEquipmentServiceEnum;
use app\models\CardOwnEquipment;
use app\models\CardOwnEquipmentHistory;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

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
         [['nama', 'lokasi', 'tanggal_produk', 'serial_number', 'suggestionTanggalServiceSelanjutnya', 'potensiService'], 'safe'],
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
    * @throws InvalidConfigException
    */
   public function search(array $params): ActiveDataProvider
   {
      $latestHistory = CardOwnEquipmentHistory::find()
         ->select([
            'id' => new Expression('MAX(id)'),
            'card_own_equipment_id' => new Expression('MAX(card_own_equipment_id)'),
            'tanggal_service_selanjutnya' => new Expression("MAX(tanggal_service_selanjutnya)"),
            'potensiService' => new Expression("
               	 IF(DATE(MAX(tanggal_service_selanjutnya)) < CURDATE(),
                        :SERVICE,
                        :SAFE
                  )
            ", [

               ':SERVICE' => PotensiCardOwnEquipmentServiceEnum::SERVICE->value,
               ':SAFE' => PotensiCardOwnEquipmentServiceEnum::SAFE->value,
            ])
         ])
         ->groupBy('card_own_equipment_history.card_own_equipment_id');

      $query = CardOwnEquipment::find()
         ->select('card_own_equipment.*')
         ->addSelect([
            'suggestionTanggalServiceSelanjutnya' => 'latestHistory.tanggal_service_selanjutnya',
            'potensiService' => new Expression("
               IF(latestHistory.potensiService IS NULL,
                  :BELUM,
                  latestHistory.potensiService
               )
            ", [
               ':BELUM' => PotensiCardOwnEquipmentServiceEnum::BELUM_ATAU_TIDAK_PERNAH_SERVICE->value,
            ])
         ])
         ->joinWith('card')
         ->leftJoin(['latestHistory' => $latestHistory], 'latestHistory.card_own_equipment_id = card_own_equipment.id');

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

      if (!empty($this->suggestionTanggalServiceSelanjutnya)) {
         $query->andFilterWhere([
            'latestHistory.tanggal_service_selanjutnya' => Yii::$app->formatter->asDate($this->suggestionTanggalServiceSelanjutnya, 'php:Y-m-d')
         ]);
      }

      if (!empty($this->potensiService)) {
         if ($this->potensiService == PotensiCardOwnEquipmentServiceEnum::BELUM_ATAU_TIDAK_PERNAH_SERVICE->value) {
            $query->andWhere(['IS', 'latestHistory.potensiService', NULL]);
         } else {
            $query->andFilterWhere(['latestHistory.potensiService' => $this->potensiService]);
         }
      }

      $query->addOrderBy('card.nama');

      return $dataProvider;
   }
}