<?php

namespace app\models;

use yii\base\Model;
use yii\db\Query;

class StockInPerBarang extends Model
{

   public ?int $id;
   public Barang|null $barang = null;
   public ?string $partNumber = null;
   public ?string $kodeBarang = null;
   public ?string $namaBarang = null;
   public ?string $merk = null;
   public ?string $stockAwal = null;
   public ?string $defaultSatuan = null;
   public ?string $qtyMasuk = null;
   public ?string $qtyKeluar = null;
   public ?string $stockAkhir = null;
   public ?string $nomorMr = null;
   public ?string $nomorTandaTerima = null;

   public function rules(): array
   {
      return [
         [['namaBarang', 'partNumber', 'kodeBarang', 'merk', 'nomorTandaTerima'], 'string'],
      ];
   }

   public function getBarang(): ?Barang
   {
      return $this->barang;
   }


   public function getData()
   {
      $data = (new Query())
         ->from(['b' => $this->barang::tableName()])
         ->select([
            'id' => 'b.id',
            'partNumber' => 'b.part_number',
            'kodeBarang' => 'b.ift_number',
            'namaBarang' => 'b.nama',
            'merk' => 'b.merk_part_number',
            'nomor_mr' => 'mr.nomor',
            'tgl_mr' => 'mr.tanggal',
            'nomor_po' => 'po.nomor',
            'tgl_po' => 'po.tanggal',
            'nomorTandaTerima' => 'ttb.nomor',
            'tgl_tanda_terima' => 'ttb.tanggal',
            'qty_terima' => 'ttbd.quantity_terima'
         ])
         ->leftJoin(['mrd' => 'material_requisition_detail'], 'mrd.barang_id = b.id ')
         ->leftJoin(['mr' => 'material_requisition'], 'mr.id = mrd.material_requisition_id ')
         ->leftJoin(['mrdp' => 'material_requisition_detail_penawaran'], 'mrdp.material_requisition_detail_id = mrd.id ')
         ->leftJoin(['po' => 'purchase_order'], 'po.id = mrdp.purchase_order_id')
         ->leftJoin(['ttbd' => 'tanda_terima_barang_detail'], 'ttbd.material_requisition_detail_penawaran_id = mrdp.id')
         ->leftJoin(['ttb' => 'tanda_terima_barang'], 'ttb.id = ttbd.tanda_terima_barang_id')
         ->where([
            'b.id' => $this->barang->id
         ]);

      return $data;
   }
}