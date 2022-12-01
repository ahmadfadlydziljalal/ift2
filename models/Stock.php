<?php

namespace app\models;

use yii\base\Model;
use yii\db\Expression;
use yii\db\Query;

class Stock extends Model
{

   public ?string $partNumber = null;
   public ?string $kodeBarang = null;
   public ?string $namaBarang = null;
   public ?string $merk = null;
   public ?string $stockAwal = null;
   public ?string $defaultSatuan = null;
   public ?string $qtyMasuk = null;
   public ?string $qtyKeluar = null;
   public ?string $stockAkhir = null;

   public function rules(): array
   {
      return [
         [['namaBarang', 'partNumber', 'kodeBarang', 'merk'], 'string'],
      ];
   }

   public function getData(): Query
   {
      return (new Query())
         ->select([
            'id' => 'init.id',
            'partNumber' => 'init.part_number',
            'kodeBarang' => 'init.ift_number',
            'namaBarang' => 'init.nama',
            'merk' => 'init.merk_part_number',
            'stockAwal' => 'init.initialize_stock_quantity',
            'defaultSatuan' => 'init.satuanNama',
            'qtyMasuk' => new Expression("COALESCE(barangMasuk.totalQuantityTerima, 0)"),
            'qtyKeluar' => new Expression("COALESCE(barangKeluar.totalQuantityKeluar, 0)"),
            'stockAkhir ' => new Expression(" (init.initialize_stock_quantity) + (COALESCE(barangMasuk.totalQuantityTerima, 0)) - (COALESCE(barangKeluar.totalQuantityKeluar, 0)) "),
         ])
         ->from(['init' => $this->getBarang()])
         ->leftJoin(['barangMasuk' => $this->getBarangMasuk()], 'barangMasuk.barangId = init.id')
         ->leftJoin(['barangKeluar' => $this->getBarangKeluar()], 'barangKeluar.barangId = init.id')
         ->orderBy('namaBarang');
   }

   public function getBarang(): active_queries\BarangQuery
   {
      return Barang::find()
         ->alias('b')
         ->select([
            'id' => 'b.id',
            'nama' => 'b.nama',
            'part_number',
            'ift_number',
            'merk_part_number',
            'satuanNama' => 's.nama',
            'initialize_stock_quantity' => 'b.initialize_stock_quantity',
         ])
         ->leftJoin(['s' => 'satuan'], 'b.default_satuan_id = s.id')
         ->orderBy('nama');
   }

   public function getBarangMasuk(): active_queries\TandaTerimaBarangDetailQuery
   {
      return TandaTerimaBarangDetail::find()
         ->select([
            'barangId' => 'b.id',
            'barangNama' => 'b.nama',
            'totalQuantityTerima' => new Expression("COALESCE(SUM(ttbd.quantity_terima), 0) "),
         ])
         ->alias('ttbd')
         ->joinWith(['tandaTerimaBarang' => function ($ttb) {
            $ttb->alias('ttb');
         }])
         ->joinWith(['materialRequisitionDetailPenawaran' => function ($mrdp) {
            $mrdp->alias('mrdp')
               ->joinWith(['materialRequisitionDetail' => function ($mrd) {
                  $mrd->alias('mrd')
                     ->joinWith(['barang' => function ($b) {
                        $b->alias('b');
                     }]);
               }]);
         }])
         ->groupBy('b.id');
   }

   public function getBarangKeluar(): active_queries\QuotationDeliveryReceiptDetailQuery
   {
      return QuotationDeliveryReceiptDetail::find()
         ->select([
            'barangId' => 'b.id',
            'barangNama' => 'b.nama',
            'totalQuantityKeluar' => new Expression("COALESCE(SUM(quotation_delivery_receipt_detail.quantity), 0) "),
         ])
         ->joinWith(['quotationBarang' => function ($qb) {
            $qb->alias('qb')
               ->joinWith(['barang' => function ($b) {
                  $b->alias('b');
               }]);
         }])
         ->joinWith(['quotationDeliveryReceipt' => function ($qdr) {
            $qdr->alias('qdr');
         }])
         ->where([
            'IS NOT', 'qdr.tanggal_konfirmasi_diterima_customer', NULL
         ])
         ->groupBy('b.id');
   }

}