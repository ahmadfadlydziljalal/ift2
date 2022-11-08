<?php

namespace app\models\active_queries;

use app\models\MaterialRequisitionDetail;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\app\models\MaterialRequisitionDetail]].
 *
 * @see \app\models\MaterialRequisitionDetail
 */
class MaterialRequisitionDetailQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MaterialRequisitionDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function createForPurchaseOrder(mixed $q): array
    {

        $query = parent::select([
            'id' => new Expression("JSON_OBJECT(
                        'material_requisition_id',  mr.id,
                        'vendor_id', c.id
                    )"),
            'text' => new Expression("CONCAT(mr.nomor, ' - ', c.nama)")
        ]);

        $query
            ->alias('mrd')
            ->joinWith(['materialRequisitionDetailPenawarans' => function ($mrdp) {
                $mrdp
                    ->alias('mrdp')
                    ->joinWith(['vendor' => function ($v) {
                        $v->alias('c');
                    }], false)
                    ->joinWith(['status' => function ($s) {
                        $s->alias('s');
                    }], false)
                    ->joinWith(['purchaseOrder' => function ($s) {
                        $s->alias('po');
                    }], false);
            }], false)
            ->joinWith(['materialRequisition' => function ($mr) {
                $mr->alias('mr');
            }], false)
            ->joinWith('barang', false)
            ->where([
                'IS NOT', 'mrdp.vendor_id', NULL
            ])
            ->andWhere([
                'IS', 'purchase_order_id', NULL
            ])
            ->andWhere([
                's.key' => 'Diterima'
            ])
            ->andWhere([
                'LIKE', 'mr.nomor', $q
            ])
            ->groupBy('mr.id, c.id');

        return $query->asArray()->all();
    }

    /**
     * @inheritdoc
     * @return MaterialRequisitionDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}