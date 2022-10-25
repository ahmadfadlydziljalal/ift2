<?php

namespace app\models;

use app\models\base\BarangSatuan as BaseBarangSatuan;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "barang_satuan".
 */
class BarangSatuan extends BaseBarangSatuan
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

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(),[
            'vendor_id' => 'Vendor',
            'satuan_id' => 'Satuan'
        ]);
    }
}