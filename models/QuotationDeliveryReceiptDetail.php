<?php

namespace app\models;

use Yii;
use \app\models\base\QuotationDeliveryReceiptDetail as BaseQuotationDeliveryReceiptDetail;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quotation_delivery_receipt_detail".
 */
class QuotationDeliveryReceiptDetail extends BaseQuotationDeliveryReceiptDetail
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
