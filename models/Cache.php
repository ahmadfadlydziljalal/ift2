<?php

namespace app\models;

use Yii;
use \app\models\base\Cache as BaseCache;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cache".
 */
class Cache extends BaseCache
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
