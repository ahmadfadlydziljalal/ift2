<?php

namespace app\models;

use app\enums\MaterialRequisitionDetailPenawaranEnum;
use app\models\base\MaterialRequisitionDetailPenawaran as BaseMaterialRequisitionDetailPenawaran;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * This is the model class for table "material_requisition_detail_penawaran".
 */
class MaterialRequisitionDetailPenawaran extends BaseMaterialRequisitionDetailPenawaran
{

    public ?string $asOptionList = null;

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
            'material_requisition_detail_id' => 'Material Requisition Detail',
            'vendor_id' => 'Vendor',
            'purchase_order_id' => 'Purchase Order',
            'mata_uang_id' => 'Mata Uang',
        ]);
    }

    public function getStatusLabel(): string
    {
        $htmlElement = Json::decode($this->status->options);
        return Html::tag(
            $htmlElement['tag'],
            $this->status->key,
            $htmlElement['options']
        );
    }

    public function getSubtotal(): float|int
    {
        return $this->quantity_pesan * $this->harga_penawaran;
    }

}