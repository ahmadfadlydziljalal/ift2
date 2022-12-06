<?php

namespace app\models\search;

use app\components\helpers\ArrayHelper;
use app\models\HistoryLokasiBarang;
use app\models\LokasiBarang;
use yii\data\ActiveDataProvider;

class LokasiBarangPerCardSearch extends LokasiBarang
{

   public ?string $cardId = null;
   public ?string $tandaTerimaBarangDetailId = null;
   public ?string $claimPettyCashNotaDetailId = null;
   public ?string $tipePergerakanId = null;

   public function attributeLabels(): array
   {
      return ArrayHelper::merge(
         HistoryLokasiBarang::$attributes, [
            'cardId' => 'card'
         ]

      );
   }

   public function rules(): array
   {
      return [
         [['cardId', 'tandaTerimaBarangDetailId', 'tipePergerakanId', 'claimPettyCashNotaDetailId'], 'integer']
      ];
   }

   public function search(array $params): ActiveDataProvider
   {

      $query = parent::getListLokasiBarangPerCard();
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

      $query->andFilterWhere(['LIKE', 'tanda_terima_barang.nomor', $this->tandaTerimaBarangDetailId]);
      $query->andFilterWhere(['LIKE', 'claim_petty_cash.nomor', $this->claimPettyCashNotaDetailId]);
      return $dataProvider;

   }
}