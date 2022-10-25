<?php

namespace app\models;

use Yii;
use \app\models\base\CardType as BaseCardType;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "card_type".
 */
class CardType extends BaseCardType
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
