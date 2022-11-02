<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\BarangSatuan;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\BarangSatuan]].
 *
 * @see \app\models\BarangSatuan
 */
class BarangSatuanQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return BarangSatuan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function map(int $barangId): array
    {
        $data = self::availableVendor($barangId);
        return ArrayHelper::map($data, 'id', 'name');
    }

    public function availableVendor($barangId): array
    {
        return parent::select('barang_satuan.vendor_id as id,card.nama as name')
            ->joinWith('vendor', false)
            ->where([
                'barang_id' => $barangId
            ])
            ->orderBy('card.nama')
            ->asArray()
            ->all();
    }

    /**
     * @inheritdoc
     * @return BarangSatuan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }


}