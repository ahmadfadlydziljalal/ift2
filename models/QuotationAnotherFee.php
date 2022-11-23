<?php

namespace app\models;

use Yii;
use \app\models\base\QuotationAnotherFee as BaseQuotationAnotherFee;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quotation_another_fee".
 */
class QuotationAnotherFee extends BaseQuotationAnotherFee
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
