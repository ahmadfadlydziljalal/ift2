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


    public ?string $barangPartNumber = null;
    public ?string $barangIftNumber = null;
    public ?string $barangMerkPartNumber = null;
    public ?string $barangNama = null;
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
                [['barang_id'], 'required', 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return ($model->tipe_pembelian_id == TipePembelianEnum::STOCK->value);
                }],

                [['barang_id'], 'compare', 'compareValue' => '', 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return ($model->tipe_pembelian_id != TipePembelianEnum::STOCK->value);
                }, 'message' => '{attribute} must be should be blank ...!'],

                [['description'], 'required', 'when' => function ($model) {
                    /** @var ClaimPettyCashNotaDetail $model */
                    return ($model->tipe_pembelian_id != TipePembelianEnum::STOCK->value);
                }],
            ]
        );
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => 'ID',
            'material_requisition_id' => 'Material Requisition',
            'tipe_pembelian_id' => 'Tipe',
            'barang_id' => 'Barang',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'satuan_id' => 'Satuan',
            'waktu_permintaan_terakhir' => 'Last Req',
            'harga_terakhir' => 'Last Price',
            'stock_terakhir' => 'Last Stock',
        ]);
    }


}