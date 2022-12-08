<?php

namespace app\models;

use app\models\base\ProformaDebitNoteDetailService as BaseProformaDebitNoteDetailService;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "proforma_debit_note_detail_service".
 */
class ProformaDebitNoteDetailService extends BaseProformaDebitNoteDetailService
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
         return $this->rate_per_hour * ($this->discount / 100);
      }

      return 0;
   }

   public function getRatePerHourAfterDiscount(): float
   {
      return ((float)$this->rate_per_hour) - ((float)$this->nominalDiscount);
   }


   /**
    * @return float|int
    */
   public function getAmountBeforeDiscount(): float|int
   {
      return ($this->hours * $this->rate_per_hour);
   }

   /**
    * @return float|int
    */
   public function getAmount(): float|int
   {
      return ($this->hours * $this->ratePerHourAfterDiscount);
   }
}