<?php

namespace app\models\search;

use app\components\helpers\ArrayHelper;
use app\models\HistoryLokasiBarang;
use app\models\LokasiBarangSearch;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class HistoryLokasiBarangSearchPerCardWarehouseSearch extends Model
{

   public ?string $nomor = null;
   public ?string $cardId = null;
   public ?string $tandaTerimaBarangDetailId = null;
   public ?string $claimPettyCashNotaDetailId = null;
   public ?string $tipePergerakanId = null;

   public function attributeLabels(): array
   {
      return ArrayHelper::merge(
         HistoryLokasiBarang::$attributes, [
            'cardId' => 'card',
         ]

      );
   }

   public function rules(): array
   {
      return [
         [['cardId', 'tandaTerimaBarangDetailId', 'tipePergerakanId', 'claimPettyCashNotaDetailId'], 'integer'],
         [['nomor'], 'safe']
      ];
   }

   public function search(array $params): ActiveDataProvider
   {

      $query = $this->getHistoryLokasiBarangPerCard();
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'key' => 'id',
      ]);

      $this->load($params);

      if (!$this->validate()) {
         return $dataProvider;
      }

      $query->andFilterWhere(condition: [
         'card_id' => $this->cardId,
         'tipe_pergerakan_id' => $this->tipePergerakanId,
      ]);

      $query->andFilterWhere(['LIKE', 'history_lokasi_barang.nomor', $this->nomor]);
      $query->andFilterWhere(['LIKE', 'tanda_terima_barang.nomor', $this->tandaTerimaBarangDetailId]);
      $query->andFilterWhere(['LIKE', 'claim_petty_cash.nomor', $this->claimPettyCashNotaDetailId]);
      return $dataProvider;

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
}