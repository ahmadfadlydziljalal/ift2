<?php

namespace app\models;

use app\enums\TipePembelianEnum;
use app\models\base\MaterialRequisitionDetail as BaseMaterialRequisitionDetail;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "material_requisition_detail".
 */
class MaterialRequisitionDetail extends BaseMaterialRequisitionDetail
{

    const SCENARIO_MR = 'mr';
    const SCENARIO_PO = 'po';

    public ?string $barangId = null;
    public ?string $barangPartNumber = null;
    public ?string $barangIftNumber = null;
    public ?string $barangMerkPartNumber = null;
    public ?string $barangNama = null;
    public ?string $tipePembelian = null;
    public ?string $tipePembelianNama = null;


    public function behaviors()
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
                ['tipePembelian', 'safe'],
                [['barang_id'], 'required', 'on' => self::SCENARIO_MR, 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return
                        in_array($model->tipePembelian, [
                            TipePembelianEnum::STOCK->value,
                            TipePembelianEnum::PERLENGKAPAN->value
                        ]);
                }, 'message' => 'Barang / Perlengkapan cannot be blank'],

                [['barang_id'], 'compare', 'compareValue' => '', 'on' => self::SCENARIO_MR, 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return !in_array($model->tipePembelian, [
                        TipePembelianEnum::STOCK->value,
                        TipePembelianEnum::PERLENGKAPAN->value
                    ]);
                }, 'message' => '{attribute} should be blank ...!'],

                [['description'], 'required', 'on' => self::SCENARIO_MR, 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return !in_array($model->tipePembelian, [
                        TipePembelianEnum::STOCK->value,
                        TipePembelianEnum::PERLENGKAPAN->value
                    ]);
                }],
            ]
        );
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'material_requisition_id' => 'Material Requisition',
            'barang_id' => 'Barang',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'satuan_id' => 'Satuan',
            'waktu_permintaan_terakhir' => 'Last Req',
            'harga_terakhir' => 'Last Price',
            'stock_terakhir' => 'Last Stock',
        ]);
    }

    public function getSubtotal()
    {
        return $this->quantity * $this->harga_terakhir;
    }


}