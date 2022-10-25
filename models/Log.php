<?php

namespace app\models;

use Yii;
use \app\models\base\Log as BaseLog;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "log".
 */
class Log extends BaseLog
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
