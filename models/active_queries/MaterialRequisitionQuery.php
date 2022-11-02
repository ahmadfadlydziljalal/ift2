<?php

namespace app\models\active_queries;

use app\models\MaterialRequisition;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\app\models\MaterialRequisition]].
 *
 * @see \app\models\MaterialRequisition
 */
class MaterialRequisitionQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MaterialRequisition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param string $q
     * @return array
     */
    public function createForPurchaseOrder(string $q): array
    {
        $sql = <<<SQL
            JSON_OBJECT('material_requisition_id',  material_requisition.id, 'vendor_id', material_requisition_detail.vendor_id )
SQL;

        return parent::select(
            [
                //'id' => new Expression('CONCAT(material_requisition.id, ";", material_requisition_detail.vendor_id)'),
                'id' => new Expression($sql),
                'text' => new Expression('CONCAT(material_requisition.nomor, " - ", card.nama)')
            ])
            ->joinWith(['materialRequisitionDetails' => function ($mrd) {
                $mrd->joinWith('vendor', false);
            }], false)
            ->where([
                'LIKE', 'nomor', $q
            ])
            ->asArray()
            ->all();
    }

    /**
     * @inheritdoc
     * @return MaterialRequisition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}