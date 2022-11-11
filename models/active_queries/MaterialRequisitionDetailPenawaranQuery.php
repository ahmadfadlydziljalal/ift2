<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\MaterialRequisitionDetailPenawaran;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\MaterialRequisitionDetailPenawaran]].
 *
 * @see \app\models\MaterialRequisitionDetailPenawaran
 */
class MaterialRequisitionDetailPenawaranQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/


    /**
     * @inheritdoc
     * @return MaterialRequisitionDetailPenawaran|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param array $materialRequestAndVendorId
     * @return array
     */
    public function forCreateAction(array $materialRequestAndVendorId): array
    {
        return parent::joinWith('materialRequisitionDetail', false)
            ->where([
                'material_requisition_id' => $materialRequestAndVendorId['material_requisition_id'],
                'material_requisition_detail_penawaran.vendor_id' => $materialRequestAndVendorId['vendor_id'],
            ])
            ->all();
    }

    /**
     * @inheritdoc
     * @return MaterialRequisitionDetailPenawaran[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function map()
    {
        $data = parent::select([
            'id' => 'mrdp.id',
            'asOptionList' => 'CONCAT(po.nomor, " ", mrdp.quantity_pesan, " ",  satuan.nama)'
        ])
            ->alias('mrdp')
            ->joinWith(['materialRequisitionDetail' => function ($mrd) {
                $mrd->alias('mrd')
                    ->joinWith('satuan');
            }])
            ->joinWith(['purchaseOrder' => function ($po) {
                $po->alias('po');
            }])
            ->where([
                'IS NOT', 'mrdp.purchase_order_id', NULL
            ])
            ->all();

        return ArrayHelper::map($data, 'id', 'asOptionList');
    }
}