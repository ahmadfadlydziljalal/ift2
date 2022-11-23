<?php

namespace app\models;

use Yii;
use \app\models\base\QuotationTermAndCondition as BaseQuotationTermAndCondition;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quotation_term_and_condition".
 */
class QuotationTermAndCondition extends BaseQuotationTermAndCondition
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
