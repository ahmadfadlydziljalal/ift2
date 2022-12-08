<?php

namespace app\models;

use app\models\base\ProformaDebitNoteDetailBarang as BaseProformaDebitNoteDetailBarang;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "proforma_debit_note_detail_barang".
 */
class ProformaDebitNoteDetailBarang extends BaseProformaDebitNoteDetailBarang
{

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
    * @return float|int
    */
   public function getNominalDiscount(): float|int
   {
      if ($this->discount) {
         return $this->unit_price * ($this->discount / 100);
      }

      return 0;
   }


   /**
    * @return string
    */
   public function getUnitPriceAfterDiscount(): string
   {
      return ((float)$this->unit_price) - ((float)$this->nominalDiscount);
   }


   /**
    * @return float|int
    */
   public function getAmountBeforeDiscount(): float|int
   {
      return $this->quantity * $this->unit_price;
   }

   /**
    * @return float|int
    */
   public function getAmount(): float|int
   {
      return ($this->quantity * $this->unitPriceAfterDiscount);
   }
}