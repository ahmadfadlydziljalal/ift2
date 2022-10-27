<?php

namespace app\models;

use app\models\base\PurchaseOrderDetail as BasePurchaseOrderDetail;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "purchase_order_detail".
 */
class PurchaseOrderDetail extends BasePurchaseOrderDetail
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

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'purchase_order_id' => 'Purchase Order',
            'barang_id' => 'Barang',
            'satuan_id' => 'Satuan',
        ]);
    }

    public function getSubtotal()
    {
        return $this->quantity * $this->price;
    }
}