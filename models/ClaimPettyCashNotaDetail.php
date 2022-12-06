<?php

namespace app\models;

use app\enums\TipePembelianEnum;
use app\models\base\ClaimPettyCashNotaDetail as BaseClaimPettyCashNotaDetail;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * This is the model class for table "claim_petty_cash_nota_detail".
 */
class ClaimPettyCashNotaDetail extends BaseClaimPettyCashNotaDetail
{

   const SCENARIO_INPUT_KE_GUDANG = 'input-ke-gudang';
   public ?string $tipePembelian = null;
   public ?float $totalQuantityTerimaPerbandiganLokasi = null;

   public function behaviors(): array
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
         ]
      );
   }

   public function rules(): array
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            ['tipePembelian', 'safe'],

            [['barang_id'], 'required', 'when' => function ($model) {
               /** @var ClaimPettyCashNotaDetail $model */
               return
                  in_array($model->tipePembelian, [
                     TipePembelianEnum::STOCK->value,
                     TipePembelianEnum::PERLENGKAPAN->value
                  ]);
            }, 'message' => 'Barang / Perlengkapan cannot be blank'],

            [['barang_id'], 'compare', 'compareValue' => '', 'when' => function ($model) {
               /** @var ClaimPettyCashNotaDetail $model */
               return !in_array($model->tipePembelian, [
                  TipePembelianEnum::STOCK->value,
                  TipePembelianEnum::PERLENGKAPAN->value
               ]);
            }, 'message' => '{attribute} should be blank ...!'],

            [['description'], 'required', 'when' => function ($model) {
               /** @var ClaimPettyCashNotaDetail $model */
               return !in_array($model->tipePembelian, [
                  TipePembelianEnum::STOCK->value,
                  TipePembelianEnum::PERLENGKAPAN->value
               ]);
            }],

            [['quantity', 'totalQuantityTerimaPerbandiganLokasi'], 'required', 'on' => self::SCENARIO_INPUT_KE_GUDANG],
            ['quantity', 'validateInputKeGudang', 'on' => self::SCENARIO_INPUT_KE_GUDANG]
         ]
      );
   }

   /**
    * @param $attribute
    * @param $params
    * @param $validator
    * @return void
    */
   public function validateInputKeGudang($attribute, $params, $validator): void
   {

      $seharusnya = round($this->quantity, 2);
      $perbandinganLokasi = round(floatval($this->totalQuantityTerimaPerbandiganLokasi), 2);

      if ($seharusnya != $perbandinganLokasi) $this->addError($attribute, ' Not match antara total terima ' . $seharusnya . ' dengan total quantity lokasi ' . $perbandinganLokasi);
   }

   public function attributeLabels(): array
   {
      return ArrayHelper::merge(
         parent::attributeLabels(),
         [
            'id' => 'ID',
            'claim_petty_cash_nota_id' => 'Claim Petty Cash Not',
            'tipePembelian' => 'Tipe Pembelian',
            'barang_id' => 'Barang',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'satuan_id' => 'Satuan',
            'harga' => 'Harga',
         ]
      );
   }

   public function getSubTotal(): float|int
   {
      return $this->quantity * $this->harga;
   }

   public function getNamaTipePembelian(): string
   {

      /** @var ClaimPettyCashNotaDetail $model */
      return isset($this->barang)
         ? $this->barang->tipePembelian->nama
         : Inflector::camel2words(TipePembelianEnum::LAIN_LAIN->name);
   }

   public function scenarios(): array
   {
      $scenarios = parent::scenarios();
      $scenarios[self::SCENARIO_INPUT_KE_GUDANG] = [
         'quantity',
         'totalQuantityTerimaPerbandiganLokasi'
      ];

      return $scenarios;
   }
}