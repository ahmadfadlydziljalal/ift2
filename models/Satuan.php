<?php

namespace app\models;

use app\models\base\Satuan as BaseSatuan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "satuan".
 */
class Satuan extends BaseSatuan
{

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
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
