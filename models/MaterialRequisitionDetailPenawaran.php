<?php

namespace app\models;

use app\models\base\MaterialRequisitionDetailPenawaran as BaseMaterialRequisitionDetailPenawaran;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "material_requisition_detail_penawaran".
 */
class MaterialRequisitionDetailPenawaran extends BaseMaterialRequisitionDetailPenawaran
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

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'material_requisition_detail_id' => 'Material Requisition Detail',
            'vendor_id' => 'Vendor',
        ]);
    }
}