<?php

namespace app\models\form;

use app\models\TandaTerimaBarangDetail;
use Yii;
use yii\base\Model;

class LaporanIncomingTandaTerimaBarang extends Model
{

    public ?string $tanggal = null;

    public function rules(): array
    {
        return [
            ['tanggal', 'required']
        ];
    }


    public function getData(): array
    {
        return TandaTerimaBarangDetail::find()
            ->select([
                'tanggal' => 'tanda_terima_barang_detail.tanggal',
                'part_number' => 'barang.part_number',
                'kode_barang' => 'barang.ift_number',
                'nama_barang' => 'barang.nama',
                'jumlah_masuk' => 'tanda_terima_barang_detail.quantity_terima',
                'keterangan' => 'tanda_terima_barang.catatan',
                'nomor_tanda_terima' => 'tanda_terima_barang.nomor'
            ])
            ->joinWith(['materialRequisitionDetailPenawaran' => function ($mrdp) {
                $mrdp->joinWith('tandaTerimaBarang');
                $mrdp->joinWith(['materialRequisitionDetail' => function ($mrd) {
                    $mrd->joinWith(['barang' => function ($b) {
                        $b->joinWith(['barangSatuans' => function ($bs) {
                            $bs->joinWith('satuan');
                        }]);
                    }]);
                }]);
            }], false)
            ->where([
                'tanda_terima_barang_detail.tanggal' => Yii::$app->formatter->asDate($this->tanggal, "php:Y-m-d")
            ])
            ->asArray()
            ->all();
    }


}