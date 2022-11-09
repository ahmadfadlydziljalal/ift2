<?php

namespace app\models\active_queries;

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
}