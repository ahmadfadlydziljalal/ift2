<?php

namespace app\models;

use Yii;
use \app\models\base\Satuan as BaseSatuan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "satuan".
 */
class Satuan extends BaseSatuan
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
