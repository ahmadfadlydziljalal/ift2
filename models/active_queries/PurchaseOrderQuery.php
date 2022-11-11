<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\PurchaseOrder;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the ActiveQuery class for [[\app\models\PurchaseOrder]].
 *
 * @see \app\models\PurchaseOrder
 */
class PurchaseOrderQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return PurchaseOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return array
     */
    public function mapListForCreateTandaTerima(): array
    {
        $subQuery = (new Query())
            ->select([
                'id' => 'po.id',
                'nomor' => 'po.nomor',
                'quantity_terima' => new Expression("COALESCE(ttbd.quantity_terima, 0)"),
            ])
            ->from(['po' => 'purchase_order'])
            ->leftJoin(
                ['mrdp' => 'material_requisition_detail_penawaran'],
                'po.id = mrdp.purchase_order_id')
            ->leftJoin(
                ['ttbd' => 'tanda_terima_barang_detail'],
                'mrdp.id = ttbd.material_requisition_detail_penawaran_id'
            )
            ->where(new Expression("COALESCE(ttbd.quantity_terima, 0) = 0"));

        $data = (new Query())
            ->select('id, nomor')
            ->from(['po_with_qty_pesan_terima' => $subQuery])
            ->groupBy('po_with_qty_pesan_terima.id');
        
        return ArrayHelper::map($data->all(), 'id', 'nomor');
    }

    /**
     * @inheritdoc
     * @return PurchaseOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}