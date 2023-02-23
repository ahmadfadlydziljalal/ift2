<?php

namespace app\models;

use Yii;
use \app\models\base\QuotationFormJobMekanik as BaseQuotationFormJobMekanik;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quotation_form_job_mekanik".
 */
class QuotationFormJobMekanik extends BaseQuotationFormJobMekanik
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
