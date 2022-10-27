<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Barang;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Barang]].
 *
 * @see \app\models\Barang
 */
class BarangQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Barang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function availableSatuan($barangId, $vendorId): array
    {
        return parent::select('satuan.id as id, satuan.nama as name')
            ->joinWith(['barangSatuans' => function ($bs) {
                return $bs->joinWith('satuan', false);
            }], false)
            ->where('barang.id =:barangId', [':barangId' => $barangId])
            ->andWhere('barang_satuan.vendor_id =:vendorId', [':vendorId' => $vendorId])
            ->asArray()
            ->all();
    }

    /**
     * @inheritdoc
     * @return Barang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function map()
    {
        return ArrayHelper::map(parent::orderBy('nama')->all(), 'id', function ($el) {
            return
                $el->part_number . ' - ' .
                $el->merk_part_number . ' - ' .
                $el->nama . ' - ' .
                $el->ift_number;
        });
    }

    public function availableVendor(int $barangId): array
    {
        return parent::select('card.id as id, card.nama as name')
            ->joinWith(['barangSatuans' => function ($bs) {
                return $bs->joinWith('vendor', false);
            }], false)
            ->where('barang.id =:barangId', [':barangId' => $barangId])
            ->asArray()
            ->all();
    }
}