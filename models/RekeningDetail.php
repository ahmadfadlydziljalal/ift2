<?php

namespace app\models;

use Yii;
use \app\models\base\RekeningDetail as BaseRekeningDetail;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rekening_detail".
 */
class RekeningDetail extends BaseRekeningDetail
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
