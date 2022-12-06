<?php

namespace app\models\form;

use app\models\TandaTerimaBarangDetail;
use yii\base\Model;

class SetLokasiBarangMovementForm extends Model
{

   /**
    * @var TandaTerimaBarangDetail|null
    * */
   public ?TandaTerimaBarangDetail $tandaTerimaBarangDetail = null;

   public ?float $totalItemTandaTerimaBarangDetail = null;
   public ?array $movementBarangItems = null;

   public function rules(): array
   {
      return [
         ['tandaTerimaBarangDetail', 'required'],
         ['tandaTerimaBarangDetail', 'validateTotalMasterDenganTotalDetail']
      ];
   }

   public function validateTotalMasterDenganTotalDetail($attribute, $params, $validator)
   {
      /*
       * @TODO
       * Algoritma yang dibutuhkan:
       *
       * 1. TotalItemTandaTerimaBarangDetail tidak boleh 0
       * 2. TotalJumlahQuantityTo === TotalItemTandaTerimaBarangDetail
       *
       * */
   }

   public function attributeLabels()
   {
      return [
         'totalItemTandaTerimaBarangDetail' => 'Total barang dalam tanda terima',
      ];
   }
}