<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\app\models\Barang]].
 *
 * @see \app\models\Barang
 */
class BarangQuery extends ActiveQuery {

    public function liveSearch(string $q): BarangQuery {
        return parent::select([
            'id'   => 'id',
            'text' => new Expression("CONCAT(barang.nama, ' - ', barang.part_number)"),
        ])->where(['LIKE', 'nama', $q])
            ->orWhere(['LIKE', 'part_number', $q])
            ->orderBy(['nama' => SORT_DESC]);
    }

    public function availableSatuan($barangId, $vendorId): array {
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
     * @param string $from
     * @param $to
     * @param int $tipePembelian
     * @return array
     */
    public function map(string $from = 'id', $to = null, int $tipePembelian = 0): array {
        $query = parent::orderBy('nama');

        if ($tipePembelian) {
            $query->where([
                'tipe_pembelian_id' => $tipePembelian
            ]);
        }

        if (is_null($to)) {
            $to = function ($el) {
                return
                    (!empty($el->part_number) ? $el->part_number : 'NO Part Number') . ' - ' .
                    (!empty($el->merk_part_number) ? $el->merk_part_number : 'NO merk') . ' - ' .
                    $el->nama . ' - ' .
                    $el->ift_number;
            };
        } else {
            $query->orderBy($to);
        }

        return ArrayHelper::map($query->all(), $from, $to);
    }

    public function availableVendor(int $barangId): array {
        return parent::select('card.id as id, card.nama as name')
            ->joinWith(['barangSatuans' => function ($bs) {
                return $bs->joinWith('vendor', false);
            }], false)
            ->where('barang.id =:barangId', [':barangId' => $barangId])
            ->asArray()
            ->all();
    }

    /**
     * Mengembalikan list barang sesuai dengan tipe pembelian. Nama Barang bersifat opsional
     * @param $tipePembelianId
     * @param string $namaBarang
     * @return array
     */
    public function byTipePembelian($tipePembelianId, string $namaBarang = ''): array {

        $expression = new Expression("
                                    CONCAT(
                                        COALESCE(part_number, 'No Part Number') , ' - ' ,
                                        COALESCE(merk_part_number, 'No Merk') , ' - ' ,
                                        COALESCE(nama, '') , ' - ' ,
                                        COALESCE(ift_number, '')
                                    )
                                    ");
        if (!empty($namaBarang)) {
            $select = [
                'id'   => 'id',
                'text' => $expression
            ];
        } else {
            $select = [
                'id'   => 'id',
                'name' => $expression
            ];
        }

        $parent = parent::select($select)
            ->where([
                'tipe_pembelian_id' => $tipePembelianId
            ]);

        if (!empty($namaBarang)) {
            $parent->andWhere(['LIKE', 'nama', $namaBarang]);
        }

        return $parent
            ->orderBy('barang.nama')
            ->asArray()
            ->all();
    }
}