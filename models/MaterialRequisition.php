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

    /**
     * @return array
     */
    public function getMaterialRequisitionDetailsGroupingByTipePembelian(): array
    {
        $parentMaterialRequisitionDetails = parent::getMaterialRequisitionDetails()
            ->select('material_requisition_detail.*')
            ->addSelect([
                'tipePembelianNama' => 'tipe_pembelian.nama',
                'barangId' => 'barang.part_number',
                'barangPartNumber' => 'barang.part_number',
                'barangIftNumber' => 'barang.ift_number',
                'barangMerkPartNumber' => 'barang.merk_part_number',
                'barangNama' => 'barang.nama',
                'satuanNama' => 'satuan.nama',
                'vendorNama' => 'card.nama',
                'penawaranDariVendor' => new Expression(
                    'JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    "vendor", vendorPenawar.nama
                                    , "harga_penawaran", FORMAT(harga_penawaran, 2)
                                    , "status", status.key
                                    , "status_options", status.options
                                    , "purchase_order_id", purchase_order.nomor
                                    
                                )
                              )'
                )
            ])
            ->joinWith(['barang' => function ($barang) {
                $barang->joinWith('tipePembelian', false);
            }], false)
            ->joinWith('satuan', false)
            ->joinWith('vendor', false)
            ->joinWith(['materialRequisitionDetailPenawarans' => function ($mrdp) {
                $mrdp->alias('mrdp')
                    ->joinWith('status', false)
                    ->joinWith(['vendor' => function ($vendorPenawar) {
                        $vendorPenawar->alias('vendorPenawar');
                    }], false)
                    ->joinWith('purchaseOrder', false);
            }], false)
            ->groupBy('material_requisition_detail.id')
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
                'vendor_id' => 'Orang Kantor',
                'approved_by_id' => 'Approved By',
                'acknowledge_by_id' => 'Acknowledge By',
            ]
        );
    }


}