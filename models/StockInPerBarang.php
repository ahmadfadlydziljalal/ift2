<?php

namespace app\models;

use yii\base\Model;
use yii\db\Expression;
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
   public ?string $idTandaTerima = null;
   public ?string $historyLokasiBarangIn = null;

   public function rules(): array
   {
      return [
         [['namaBarang', 'partNumber', 'kodeBarang', 'merk', 'nomorTandaTerima'], 'string'],
         [['historyLokasiBarangIn'], 'safe'],
      ];
   }

   public function getBarang(): ?Barang
   {
      return $this->barang;
   }


   public function getData(): Query
   {
      $init = (new Query())
         ->from(['b' => $this->barang::tableName()])
         ->select([
            'id' => 'ttbd.id',
            'partNumber' => 'b.part_number',
            'kodeBarang' => 'b.ift_number',
            'namaBarang' => 'b.nama',
            'merk' => 'b.merk_part_number',
            'nomor_mr' => 'mr.nomor',
            'tgl_mr' => 'mr.tanggal',
            'nomor_po' => 'po.nomor',
            'tgl_po' => 'po.tanggal',
            'idTandaTerima' => 'ttb.id',
            'nomorTandaTerima' => 'ttb.nomor',
            'tgl_tanda_terima' => 'ttb.tanggal',
            'qty_terima' => 'ttbd.quantity_terima',
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

      return (new Query())
         ->select('init.*, history.historyLokasiBarangIn')
         ->from(['init' => $init])
         ->leftJoin(['history' => $this->getHistoryLokasiBarangIn()], 'init.id =  history.id');
   }


   /**
    * @return Query
    */
   public function getHistoryLokasiBarangIn(): Query
   {
      return (new Query())
         ->select([
            'id' => 'ttbd.id',
            'historyLokasiBarangIn' => new Expression("
               JSON_ARRAYAGG(
                  JSON_OBJECT(
                     'id', hlb.id, 
                     'lokasi', CONCAT(hlb.block, hlb.rak, hlb.tier, hlb.row),
                     'quantity', hlb.quantity
                  )
               )")
         ])
         ->from(['ttbd' => 'tanda_terima_barang_detail'])
         ->leftJoin(['hlb' => 'history_lokasi_barang'], 'ttbd.id = hlb.tanda_terima_barang_detail_id')
         ->leftJoin(['mrdp' => 'material_requisition_detail_penawaran'], 'ttbd.material_requisition_detail_penawaran_id = mrdp.id')
         ->leftJoin(['mrd' => 'material_requisition_detail'], 'mrdp.material_requisition_detail_id = mrd.id')
         ->leftJoin(['b' => 'barang'], 'mrd.barang_id = b.id')
         ->leftJoin(['s' => 'status'], 'hlb.tipe_pergerakan_id = s.id')
         ->where([
            'b.id' => $this->barang->id
         ])
         ->andWhere([
            'IS NOT', 'hlb.id', NULL
         ])
         ->andWhere([
            's.section' => 'set-stock-per-gudang'
         ])
         ->andWhere([
            's.key' => Stock::TIPE_PERGERAKAN_IN
         ])
         ->groupBy('id');
   }

}