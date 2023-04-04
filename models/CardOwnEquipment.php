<?php

namespace app\models;

use app\models\base\CardOwnEquipment as BaseCardOwnEquipment;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "card_own_equipment".
 */
class CardOwnEquipment extends BaseCardOwnEquipment
{
   
   public ?string $suggestionTanggalServiceSelanjutnya = null;
   public ?string $potensiService = null;

   public function behaviors()
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
         ]
      );
   }

   public function rules()
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
         ]
      );
   }

   /**
    * @return array
    */
   public function attributeLabels(): array
   {
      return ArrayHelper::merge(parent::attributeLabels(), [
         'id' => 'ID',
         'card_id' => 'Card',
         'nama' => 'Nama Unit',
         'lokasi' => 'Lokasi',
         'tanggal_produk' => 'Tgl. Produk',
         'serial_number' => 'Serial Number',
         'suggestionTanggalServiceSelanjutnya' => 'Tanggal Terakhir'
      ]);
   }


}