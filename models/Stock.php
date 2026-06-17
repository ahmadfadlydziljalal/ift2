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

class Stock extends Model {

    const TIPE_PERGERAKAN_START_PERTAMA_KALI_PENERAPAN_SISTEM = 'start-pertama-kali-penerapan-sistem';
    const TIPE_PERGERAKAN_MOVEMENT_FROM = 'movement-from';
    const TIPE_PERGERAKAN_MOVEMENT_TO = 'movement-to';
    const TIPE_PERGERAKAN_IN = 'in';

    public ?string $idBarang = null;
    public ?string $partNumber = null;
    public ?string $photoThumbnail = null;
    public ?string $kodeBarang = null;
    public ?string $namaBarang = null;
    public ?string $merk = null;
    public ?string $defaultSatuan = null;
    public ?string $stockAwal = null;
    public ?string $qtyMasuk = null;
    public ?string $qtyKeluar = null;
    public ?string $stockAkhir = null;
    public ?string $lastQuotationUnitPricesHistory = null;

    public function rules(): array {
        return [
            [['lastQuotationUnitPricesHistory',
                'photoThumbnail', 'namaBarang', 'partNumber', 'kodeBarang', 'merk', 'defaultSatuan',
                'stockAwal',
                'stockAkhir',
                'qtyMasuk',
                'qtyKeluar',
            ], 'safe'],
            [['idBarang'], 'integer'],
        ];
    }

    /**
     * @return Query
     */
    public function getData(): Query {
        return (new Query())
            ->select([
                'idBarang'                       => 'init.id',
                'partNumber'                     => 'init.part_number',
                'photoThumbnail'                 => 'init.photo_thumbnail',
                'kodeBarang'                     => 'init.ift_number',
                'namaBarang'                     => 'init.nama',
                'merk'                           => 'init.merk_part_number',
                'defaultSatuan'                  => 'init.satuanNama',
                'stockAwal'                      => 'init.initialize_stock_quantity',
                'qtyMasuk'                       => new Expression("COALESCE(barangMasuk.totalQuantityTerima, 0)"),
                'qtyKeluar'                      => new Expression("COALESCE(barangKeluar.totalQuantityKeluar, 0)"),
                'stockAkhir'                     => new Expression(" (init.initialize_stock_quantity) + (COALESCE(barangMasuk.totalQuantityTerima, 0)) - (COALESCE(barangKeluar.totalQuantityKeluar, 0)) "),
                'lastQuotationUnitPricesHistory' => 'init.lastQuotationUnitPricesHistory',
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
    public function getBarang(): active_queries\BarangQuery {
        return Barang::find()
            ->joinWith([
                'quotationBarangs',
                'quotationBarangs.quotation',
                'quotationBarangs.quotation.customer',
            ])
            ->alias('b')
            ->select([
                'id'                             => new Expression("MAX(b.id)"),
                'nama'                           => 'b.nama',
                'part_number',
                'photo_thumbnail',
                'ift_number',
                'merk_part_number',
                'satuanNama'                     => 's.nama',
                'initialize_stock_quantity'      => 'b.initialize_stock_quantity',
                'lastQuotationUnitPricesHistory' => new Expression("(
                                SELECT JSON_ARRAYAGG(JSON_OBJECT(
                                    'mata_uang', curr,
                                    'unit_price', x.unit_price,
                                    'quotation_id', x.quotation_id,
                                    'quotation_nomor', x.quotation_nomor,
                                    'customer_nama', x.customer_nama
                                ))
                                FROM (
                                    SELECT 
                                        qb.unit_price,
                                        qb.quotation_id,
                                        q.nomor AS quotation_nomor,
                                        c.nama AS customer_nama,
                                        mu.singkatan as curr
                                    FROM quotation_barang qb
                                    LEFT JOIN quotation q ON q.id = qb.quotation_id
                                    LEFT JOIN card c ON c.id = q.customer_id
                                    LEFT JOIN mata_uang mu ON mu.id = q.mata_uang_id
                                    WHERE qb.barang_id = b.id
                                    ORDER BY qb.id DESC
                                    LIMIT 5
                                ) x
                            )"),
            ])
            ->leftJoin(['s' => 'satuan'], 'b.default_satuan_id = s.id')
            ->groupBy('b.id')
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
    public function getBarangMasuk(): Query {
        $q1 = (new Query())
            ->select('*')
            ->from(['q1' => $this->getBarangMasukDariTandaTerimaBarangDetail()]);

        $q2 = (new Query())
            ->select('*')
            ->from(['q2' => $this->getBarangMasukDariClaimPettyCashNotaDetail()]);

        $q1->union($q2);
        return (new Query())
            ->select([
                'barangId'            => 'barangId',
                'barangNama'          => 'barangNama',
                'totalQuantityTerima' => new Expression('SUM(totalQuantityTerima)'),
            ])
            ->from(['barangMasuk' => $q1])
            ->groupBy('barangId, barangNama')
            ->orderBy('barangId');
    }

    /**
     * @return TandaTerimaBarangDetailQuery
     */
    public function getBarangMasukDariTandaTerimaBarangDetail(): active_queries\TandaTerimaBarangDetailQuery {
        return TandaTerimaBarangDetail::find()
            ->select([
                'type'                => new Expression('"from_ttb"'),
                'barangId'            => 'b.id',
                'barangNama'          => 'b.nama',
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
    public function getBarangMasukDariClaimPettyCashNotaDetail(): active_queries\ClaimPettyCashNotaDetailQuery {
        return ClaimPettyCashNotaDetail::find()
            ->select([
                'type'                => new Expression('"from_cpc"'),
                'barangId'            => 'b.id',
                'barangNama'          => 'b.nama',
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
    public function getBarangKeluarDariQuotationDeliveryReceiptDetail(): active_queries\QuotationDeliveryReceiptDetailQuery {
        return QuotationDeliveryReceiptDetail::find()
            ->select([
                'barangId'            => 'b.id',
                'barangNama'          => 'b.nama',
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