<?php

namespace app\models\search;

use app\enums\TipePembelianEnum;
use app\enums\TipePergerakanBarangEnum;
use app\models\active_queries\BarangQuery;
use app\models\Barang;
use app\models\Card;
use app\models\HistoryLokasiBarang;
use app\models\Status;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\Inflector;

/*
 * StockPerGudangByCardSearch me-representasi-kan stock barang yang ada di sebuah gudang
 * */

class StockPerGudangByCardSearch extends Barang
{


   public ?Card $card = null;

   public function rules(): array
   {
      return [
         [['photo_thumbnail', 'nama', 'part_number', 'ift_number',
            'merk_part_number'
         ], 'safe']
      ];
   }

   /**
    * bypass scenarios() implementation in the parent class
    * @return array
    */
   public function scenarios(): array
   {
      return Model::scenarios();
   }

   /**
    * Alternative yang diajukan:
    * Provide Card yang berperan sebagai warehouse; then:
    *
    * Query ke masing-masing jenis business process lokasi barang dari:
    * 1.0 (0) Init start project
    * 2. Barang masuk
    * 2.1 (+) Dari Tanda Terima Barang Detail
    * 2.2 (+) Dari Claim Petty Cash Nota Detail
    * 3. Barang Keluar
    * 3.1 (-) Dari Delivery Receipt
    * 4. Perpindahan barang
    * 4.1 (+) Transfer Barang masuk ke gudang     (Movement To)
    * 4.2 (-) Transfer Barang keluar dari gudang  (Movement From)
    *
    * @param array $params
    * @return ActiveDataProvider
    */
   public function search(array $params): ActiveDataProvider
   {
      $query = $this->getQuery();
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'key' => 'id',
      ]);

      $this->load($params);

      if (!$this->validate()) {
         return $dataProvider;
      }

      $query->andFilterWhere(['like', 'part_number', $this->part_number]);
      $query->andFilterWhere(['like', 'ift_number', $this->ift_number]);
      $query->andFilterWhere(['like', 'b.nama', $this->nama]);
      $query->andFilterWhere(['like', 'merk_part_number', $this->merk_part_number]);
      return $dataProvider;

   }

   /**
    * @return BarangQuery
    */
   public function getQuery(): BarangQuery
   {
      $qtyInit = new Expression("(COALESCE(initStartProject.quantity, 0))");
      $qtyTandaTerimaBarang = new Expression("(COALESCE(tandaTerimaBarangDetail.quantity, 0))");
      $qtyClaimPettyCashNota = new Expression("(COALESCE(claimPettyCashNotaDetail.quantity, 0))");
      $qtyDeliveryReceipt = new Expression("(COALESCE(deliveryReceipt.quantity, 0))");
      $qtyTransferMasuk = new Expression("(COALESCE(transferMasuk.quantity, 0))");
      $qtyTransferKeluar = new Expression("(COALESCE(transferKeluar.quantity, 0))");

      $query = $this->getBarang()
         ->select([
            'id' => 'b.id',
            'nama' => 'b.nama',
            'part_number' => 'b.part_number',
            'photo_thumbnail' => 'b.photo_thumbnail',
            'ift_number' => 'b.ift_number',
            'merk_part_number' => 'b.merk_part_number',
            'satuanNama' => 's.nama',
         ]);

      # 1.0 (0) Init start project (DONE)
      $query->addSelect(['qtyInit' => $qtyInit]);
      $query->leftJoin(
         ['initStartProject' => $this->getInitStartProject()],
         'initStartProject.barang_id = b.id'
      );

      # 2.1 (+) Dari Tanda Terima Barang Detail (DONE)
      $query->addSelect(['qtyTandaTerimaBarang' => $qtyTandaTerimaBarang]);
      $query->leftJoin(
         ['tandaTerimaBarangDetail' => $this->getTandaTerimaBarangDetail()],
         'tandaTerimaBarangDetail.barang_id = b.id'
      );

      # 2.2 (+) Dari Claim Petty Cash Nota Detail (DONE)
      $query->addSelect(['qtyClaimPettyCashNota' => $qtyClaimPettyCashNota]);
      $query->leftJoin(
         ['claimPettyCashNotaDetail' => $this->getClaimPettyCashNotaDetail()],
         'claimPettyCashNotaDetail.barang_id = b.id'
      );

      # 3.1 (-) Dari Delivery Receipt (DONE)
      $query->addSelect(['qtyDeliveryReceipt' => $qtyDeliveryReceipt]);
      $query->leftJoin(
         ['deliveryReceipt' => $this->getDeliveryReceipt()],
         'deliveryReceipt.barang_id = b.id'
      );

      #  4.1 (+) Transfer Barang masuk ke gudang     (Movement To)
      $query->addSelect(['qtyTransferMasuk' => $qtyTransferMasuk]);
      $query->leftJoin(
         ['transferMasuk' => $this->getTransferBarangMasuk()],
         'transferMasuk.barang_id = b.id'
      );

      #  4.2 (-) Transfer Barang keluar dari gudang  (Movement From)
      $query->addSelect(['qtyTransferKeluar' => $qtyTransferKeluar]);
      $query->leftJoin(
         ['transferKeluar' => $this->getTransferBarangKeluar()],
         'transferKeluar.barang_id = b.id'
      );

      $query->addSelect([
         'availableStock' => new Expression(
            $qtyInit
            . '+' . $qtyTandaTerimaBarang
            . '+' . $qtyClaimPettyCashNota
            . '-' . $qtyDeliveryReceipt
            . '+' . $qtyTransferMasuk
            . '-' . $qtyTransferKeluar
         )
      ]);
      return $query;
   }

   /**
    * 0.0 Base query adalah table barang
    * @return BarangQuery
    */
   protected function getBarang(): BarangQuery
   {
      return Barang::find()
         ->alias('b')
         ->leftJoin(['s' => 'satuan'], 'b.default_satuan_id = s.id')
         ->where('tipe_pembelian_id = :tipePembelianId', [':tipePembelianId' => TipePembelianEnum::STOCK->value])
         ->orderBy('b.nama');
   }

   /**
    * 1.0 (0) Init start project
    * @return ActiveQuery
    */
   protected function getInitStartProject(): ActiveQuery
   {
      $status = Status::findOne([
         'section' => Status::SECTION_SET_LOKASI_BARANG,
         'key' => Inflector::slug(
            str_replace('_', '-', TipePergerakanBarangEnum::START_PERTAMA_KALI_PENERAPAN_SISTEM->name)
         )
      ]);

      return HistoryLokasiBarang::find()
         ->select([
            'barang_id' => 'hlb.barang_id',
            'quantity' => new Expression('SUM(quantity)'),
         ])
         ->alias('hlb')
         ->joinWith(['card' => fn($card) => $card->alias('c')])
         ->joinWith(['barang' => fn($barang) => $barang->alias('b')])
         ->where(['c.id' => $this->card->id])
         ->andWhere(['IS NOT', 'b.id', NULL])
         ->andWhere(['hlb.tipe_pergerakan_id' => $status->id])
         ->andWhere(['IS', 'hlb.depend_id', NULL])
         ->groupBy('barang_id');
   }

   /**
    * 2.1 (+) Dari Tanda Terima Barang Detail
    * @return ActiveQuery
    */
   protected function getTandaTerimaBarangDetail(): ActiveQuery
   {
      return HistoryLokasiBarang::find()
         ->select([
            'barang_id' => 'mrd.barang_id',
            'quantity' => new Expression('SUM(hlb.quantity)'),
         ])
         ->alias('hlb')
         ->joinWith(['card' => fn($card) => $card->alias('c')])
         ->joinWith(['tandaTerimaBarangDetail' => fn($ttbd) => $ttbd->alias('ttbd')
            ->joinWith(['materialRequisitionDetailPenawaran' => fn($mrdp) => $mrdp->alias('mrdp')
               ->joinWith(['materialRequisitionDetail' => fn($mrd) => $mrd->alias('mrd')])
            ])
         ])
         ->where([
            'c.id' => $this->card->id
         ])
         ->andWhere([
            'IS NOT', 'ttbd.id', NULL
         ])
         ->groupBy('barang_id');
   }

   /**
    * 2.2 (+) Dari Claim Petty Cash Nota Detail
    * @return ActiveQuery
    */
   protected function getClaimPettyCashNotaDetail(): ActiveQuery
   {
      return HistoryLokasiBarang::find()
         ->alias('hlb')
         ->select([
            'barang_id' => 'cpcnd.barang_id',
            'quantity' => new Expression('SUM(hlb.quantity)'),
         ])
         ->joinWith(['card' => fn($card) => $card->alias('c')])
         ->joinWith(['claimPettyCashNotaDetail' => fn($cpcnd) => $cpcnd->alias('cpcnd')])
         ->where(['c.id' => $this->card->id])
         ->andWhere([
            'IS NOT', 'cpcnd.id', NULL
         ])
         ->groupBy('barang_id');
   }

   /**
    * 3.1 (-) Dari Delivery Receipt
    * @return ActiveQuery
    */
   protected function getDeliveryReceipt(): ActiveQuery
   {
      return HistoryLokasiBarang::find()
         ->alias('hlb')
         ->select([
            'barang_id' => 'qb.barang_id',
            'quantity' => new Expression('SUM(hlb.quantity)'),
         ])
         ->joinWith(['card' => fn($card) => $card->alias('c')])
         ->joinWith(['quotationDeliveryReceiptDetail' => fn($qdrd) => $qdrd->alias('qdrd')
            ->joinWith(['quotationBarang' => fn($qb) => $qb->alias('qb')])
         ])
         ->where(['c.id' => $this->card->id])
         ->andWhere(['IS NOT', 'qdrd.id', NULL])
         ->groupBy('qb.barang_id');

   }

   /**
    * 4.1 (+) Transfer Barang masuk ke gudang     (Movement To)
    * @return ActiveQuery
    */
   protected function getTransferBarangMasuk(): ActiveQuery
   {
      $status = Status::findOne([
         'section' => Status::SECTION_SET_LOKASI_BARANG,
         'key' => Inflector::slug(
            str_replace('_', '-', TipePergerakanBarangEnum::MOVEMENT_TO->name)
         )
      ]);

      return HistoryLokasiBarang::find()
         ->alias('inGudang')
         ->select([
            'barang_id' => 'asalGudang.barang_id',
            'quantity' => new Expression('SUM(inGudang.quantity)'),
         ])
         ->joinWith(['card' => fn($card) => $card->alias('c')])
         ->joinWith(['depend' => fn($asalGudang) => $asalGudang->alias('asalGudang')])
         ->where(['c.id' => $this->card->id])
         ->andWhere(['IS NOT', 'inGudang.depend_id', NULL])
         ->andWhere(['inGudang.tipe_pergerakan_id' => $status->id])
         ->groupBy('asalGudang.barang_id');

   }

   /**
    * 4.2 (-) Transfer Barang keluar dari gudang  (Movement From)
    * @return ActiveQuery
    */
   protected function getTransferBarangKeluar(): ActiveQuery
   {
      $status = Status::findOne([
         'section' => Status::SECTION_SET_LOKASI_BARANG,
         'key' => Inflector::slug(
            str_replace('_', '-', TipePergerakanBarangEnum::MOVEMENT_FROM->name)
         )
      ]);

      return HistoryLokasiBarang::find()
         ->alias('asalGudang')
         ->select([
            'barang_id' => 'asalGudang.barang_id',
            'quantity' => new Expression('SUM(asalGudang.quantity)'),
         ])
         ->joinWith(['card' => fn($card) => $card->alias('c')])
         ->where(['c.id' => $this->card->id])
         ->andWhere(['asalGudang.tipe_pergerakan_id' => $status->id])
         ->groupBy('asalGudang.barang_id');
   }


}