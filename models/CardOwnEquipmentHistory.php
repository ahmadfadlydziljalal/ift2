<?php

namespace app\models;

use app\models\base\CardOwnEquipmentHistory as BaseCardOwnEquipmentHistory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "card_own_equipment_history".
 */
class CardOwnEquipmentHistory extends BaseCardOwnEquipmentHistory
{
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
}