<?php

namespace app\models;

use app\models\base\TandaTerimaBarangDetail as BaseTandaTerimaBarangDetail;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tanda_terima_barang_detail".
 */
class TandaTerimaBarangDetail extends BaseTandaTerimaBarangDetail
{

   const SCENARIO_INPUT_KE_GUDANG = 'input-ke-gudang';

   public ?int $barangId = null;
   public ?string $barangNama = null;
   public ?float $totalQuantityTerima = null;
   public ?float $totalQuantityTerimaPerbandiganLokasi = null;
   public ?string $type;

   public function behaviors()
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
            # custom validation rules
            [['quantity_terima', 'totalQuantityTerimaPerbandiganLokasi'], 'required', 'on' => self::SCENARIO_INPUT_KE_GUDANG],
            /* @see TandaTerimaBarangDetail::validateInputKeGudang() */
            ['quantity_terima', 'validateInputKeGudang', 'on' => self::SCENARIO_INPUT_KE_GUDANG]

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

      $seharusnya = round($this->quantity_terima, 2);
      $perbandinganLokasi = round(floatval($this->totalQuantityTerimaPerbandiganLokasi), 2);

      if ($seharusnya != $perbandinganLokasi) $this->addError($attribute, ' Not match antara total terima ' . $seharusnya . ' dengan total quantity lokasi ' . $perbandinganLokasi);
   }


   public function scenarios()
   {
      $scenarios = parent::scenarios();
      $scenarios[self::SCENARIO_INPUT_KE_GUDANG] = [
         'quantity_terima',
         'totalQuantityTerimaPerbandiganLokasi'
      ];

      return $scenarios;
   }


}