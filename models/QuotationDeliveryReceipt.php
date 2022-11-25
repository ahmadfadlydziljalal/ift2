<?php

namespace app\models;

use app\models\base\QuotationDeliveryReceipt as BaseQuotationDeliveryReceipt;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quotation_delivery_receipt".
 */
class QuotationDeliveryReceipt extends BaseQuotationDeliveryReceipt
{

   public function behaviors()
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
            [
               'class' => 'mdm\autonumber\Behavior',
               'attribute' => 'nomor', // required
               'value' => '?' . '/IFTJKT/FJ/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
               'digit' => 4
            ],
         ]
      );
   }

   public function rules(): array
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
         ]
      );
   }
}