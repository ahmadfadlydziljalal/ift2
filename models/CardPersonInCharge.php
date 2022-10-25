<?php

namespace app\models;

use Yii;
use \app\models\base\CardPersonInCharge as BaseCardPersonInCharge;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "card_person_in_charge".
 */
class CardPersonInCharge extends BaseCardPersonInCharge
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
