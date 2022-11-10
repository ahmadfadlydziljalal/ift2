<?php

namespace app\models;

use Yii;
use \app\models\base\MataUang as BaseMataUang;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "mata_uang".
 */
class MataUang extends BaseMataUang
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
