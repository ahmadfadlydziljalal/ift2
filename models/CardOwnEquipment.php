<?php

namespace app\models;

use Yii;
use \app\models\base\CardOwnEquipment as BaseCardOwnEquipment;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "card_own_equipment".
 */
class CardOwnEquipment extends BaseCardOwnEquipment
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
}
