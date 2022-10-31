<?php

namespace app\models;

use app\models\base\MaterialRequisition as BaseMaterialRequisition;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "material_requisition".
 */
class MaterialRequisition extends BaseMaterialRequisition
{


    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors

                [
                    'class' => 'mdm\autonumber\Behavior',
                    'attribute' => 'nomor', // required
                    'value' => '?' . '/IFTJKT/MR/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
                    'digit' => 4
                ],
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

    public function getMaterialRequisitionDetailsGroupingByTipePembelian(): array
    {
        $parentMaterialRequisitionDetails = parent::getMaterialRequisitionDetails()
            ->select([
                'tipePembelianNama' => 'tipe_pembelian.nama',
                'barangPartNumber' => 'barang.part_number',
                'barangIftNumber' => 'barang.ift_number',
                'barangMerkPartNumber' => 'barang.merk_part_number',
                'barangNama' => 'barang.nama',
                'description' => 'material_requisition_detail.description',
                'quantity' => 'material_requisition_detail.quantity',
                'nama_satuan' => 'satuan.nama',
                'last_req' => 'material_requisition_detail.waktu_permintaan_terakhir',
                'last_price' => 'material_requisition_detail.harga_terakhir',
                'last_stock' => 'material_requisition_detail.stock_terakhir',
            ])
            ->joinWith('barang', false)
            ->joinWith('tipePembelian', false)
            ->joinWith('satuan', false)
            ->asArray()
            ->all();

        return ArrayHelper::index(
            $parentMaterialRequisitionDetails,
            null,
            'tipePembelianNama'
        );

    }

}