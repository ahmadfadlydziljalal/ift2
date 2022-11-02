<?php

namespace app\models;

use app\models\base\MaterialRequisition as BaseMaterialRequisition;
use yii\db\ActiveQuery;
use yii\db\Expression;
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
                'description' => new Expression('CONCAT(barang.nama, " " ,COALESCE(material_requisition_detail.description, ""))'),
                'quantity' => 'material_requisition_detail.quantity',
                'satuanNama' => 'satuan.nama',
                'last_req' => 'material_requisition_detail.waktu_permintaan_terakhir',
                'last_price' => 'material_requisition_detail.harga_terakhir',
                'last_stock' => 'material_requisition_detail.stock_terakhir',
            ])
            ->joinWith(['barang' => function ($barang) {
                $barang->joinWith('tipePembelian', false);
            }], false)
            ->joinWith('satuan', false)
            ->asArray()
            ->all();

        return ArrayHelper::index(
            $parentMaterialRequisitionDetails,
            null,
            'tipePembelianNama'
        );

    }

    public function getMaterialRequisitionDetails(): ActiveQuery
    {
        return parent::getMaterialRequisitionDetails()
            ->select('material_requisition_detail.*')
            ->addSelect('barang.tipe_pembelian_id as tipePembelian')
            ->joinWith('barang');
    }


    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
                'vendor_id' => 'Orang Kantor'
            ]
        );
    }

}