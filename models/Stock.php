<?php

namespace app\models;

use app\enums\TipePembelianEnum;
use app\models\active_queries\BarangQuery;
use app\models\active_queries\ClaimPettyCashNotaDetailQuery;
use app\models\active_queries\QuotationDeliveryReceiptDetailQuery;
use app\models\active_queries\TandaTerimaBarangDetailQuery;
use yii\base\Model;
use yii\db\Expression;
use yii\db\Query;

class Stock extends Model
{

   const TIPE_PERGERAKAN_START_PERTAMA_KALI_PENERAPAN_SISTEM = 'start-pertama-kali-penerapan-sistem';
   const TIPE_PERGERAKAN_MOVEMENT_FROM = 'movement-from';
   const TIPE_PERGERAKAN_MOVEMENT_TO = 'movement-to';
   const TIPE_PERGERAKAN_IN = 'in';

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

   /**
    * @return Query
    */
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
            'photo_thumbnail',
            'defaultSatuan' => 'init.satuanNama',
            'qtyMasuk' => new Expression("COALESCE(barangMasuk.totalQuantityTerima, 0)"),
            'qtyKeluar' => new Expression("COALESCE(barangKeluar.totalQuantityKeluar, 0)"),
            'stockAkhir ' => new Expression(" (init.initialize_stock_quantity) + (COALESCE(barangMasuk.totalQuantityTerima, 0)) - (COALESCE(barangKeluar.totalQuantityKeluar, 0)) "),
         ])
         ->from(['init' => $this->getBarang()])
         ->leftJoin(['barangMasuk' => $this->getBarangMasuk()], 'barangMasuk.barangId = init.id')
         ->leftJoin(['barangKeluar' => $this->getBarangKeluarDariQuotationDeliveryReceiptDetail()], 'barangKeluar.barangId = init.id')
         ->orderBy('namaBarang');
   }

   /**
    * Get Master Barang
    * @return BarangQuery
    */
   public function getBarang(): active_queries\BarangQuery
   {
      return Barang::find()
         ->alias('b')
         ->select([
            'id' => 'b.id',
            'nama' => 'b.nama',
            'part_number',
            'photo_thumbnail',
            'ift_number',
            'merk_part_number',
            'satuanNama' => 's.nama',
            'initialize_stock_quantity' => 'b.initialize_stock_quantity',
         ])
         ->leftJoin(['s' => 'satuan'], 'b.default_satuan_id = s.id')
         ->where('tipe_pembelian_id = :tipePembelianId', [':tipePembelianId' => TipePembelianEnum::STOCK->value])
         ->orderBy('nama');
   }

   /**
    * Calculate barang masuk dari beberapa prosedur proses bisnis:
    * 1. Tanda terima barang
    * 2. Claim petty cash
    *
    * @return Query
    */
   public function getBarangMasuk(): Query
   {
      $q1 = (new Query())
         ->select('*')
         ->from(['q1' => $this->getBarangMasukDariTandaTerimaBarangDetail()]);

      $q2 = (new Query())
         ->select('*')
         ->from(['q2' => $this->getBarangMasukDariClaimPettyCashNotaDetail()]);

      $q1->union($q2);
      return (new Query())
         ->select([
            'barangId' => 'barangId',
            'barangNama' => 'barangNama',
            'totalQuantityTerima' => new Expression('SUM(totalQuantityTerima)'),
         ])
         ->from(['barangMasuk' => $q1])
         ->groupBy('barangId, barangNama')
         ->orderBy('barangId');
   }

   /**
    * @return TandaTerimaBarangDetailQuery
    */
   public function getBarangMasukDariTandaTerimaBarangDetail(): active_queries\TandaTerimaBarangDetailQuery
   {
      return TandaTerimaBarangDetail::find()
         ->select([
            'type' => new Expression('"from_ttb"'),
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

   /**
    * @return ClaimPettyCashNotaDetailQuery
    */
   public function getBarangMasukDariClaimPettyCashNotaDetail(): active_queries\ClaimPettyCashNotaDetailQuery
   {
      return ClaimPettyCashNotaDetail::find()
         ->select([
            'type' => new Expression('"from_cpc"'),
            'barangId' => 'b.id',
            'barangNama' => 'b.nama',
            'totalQuantityTerima' => new Expression("COALESCE(SUM(cpcnd.quantity), 0) "),
         ])
         ->alias('cpcnd')
         ->joinWith(['claimPettyCashNota' => function ($claimPettyCashNota) {
            $claimPettyCashNota->joinWith('claimPettyCash');
         }])
         ->joinWith(['barang' => function ($barang) {
            $barang
               ->alias('b')
               ->joinWith('tipePembelian');
         }])
         ->where([
            'b.tipe_pembelian_id' => TipePembelianEnum::STOCK->value
         ])
         ->groupBy('b.id')
         ->orderBy('b.id');
   }

   /**
    * @return QuotationDeliveryReceiptDetailQuery
    */
   public function getBarangKeluarDariQuotationDeliveryReceiptDetail(): active_queries\QuotationDeliveryReceiptDetailQuery
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