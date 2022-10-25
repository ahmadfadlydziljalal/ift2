<?php

namespace app\models;

use Yii;
use \app\models\base\CardBelongsType as BaseCardBelongsType;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "card_belongs_type".
 */
class CardBelongsType extends BaseCardBelongsType
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
