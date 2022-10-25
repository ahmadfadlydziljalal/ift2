<?php

namespace app\models;

use Yii;
use \app\models\base\Originalitas as BaseOriginalitas;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "originalitas".
 */
class Originalitas extends BaseOriginalitas
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
