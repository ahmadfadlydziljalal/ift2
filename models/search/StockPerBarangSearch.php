<?php

namespace app\models\search;

use app\enums\TipePergerakanBarangEnum;
use app\models\Barang;
use app\models\Card;
use app\models\HistoryLokasiBarang;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;

/*
 * Class untuk meng-handle stock per barang;
 *
 * Element record yang dipakai:
 *
 * 1. Tanda Terima Barang
 * 2. Claim Petty Cash
 * 3. Delivery Receipt
 * 4. Perpindahan barang
 *
 * */

class StockPerBarangSearch extends Model
{

   public ?int $id;
   public Barang $barang;
   public ?string $type = null;
   public ?string $nomorHistory = null;
   public ?string $dependNomorDokumen = null;
   public ?string $gudangId = null;
   public ?string $gudang = null;

   /**
    * @return array[]
    */
   public function rules(): array
   {
      return [
         [['type', 'nomorHistory', 'dependNomorDokumen', 'gudang', 'gudangId'], 'string'],
      ];
   }

   /**
    * @inheritdoc
    */
   public function scenarios(): array
   {
      // bypass scenarios() implementation in the parent class
      return Model::scenarios();
   }

   /**
    * @param array $params
    * @return ActiveDataProvider
    */
   public function search(array $params): ActiveDataProvider
   {
      $query = $this->getQuery();

      $dataProvider = new ActiveDataProvider([
         'query' => $query,
      ]);

      $this->load($params);

      if (!$this->validate()) {
         return $dataProvider;
      }
      $query
         ->andFilterWhere([
            'type' => $this->type,
            'gudangId' => $this->gudangId
         ]);

      $query
         ->andFilterWhere(['LIKE', 'nomorHistory', $this->nomorHistory])
         ->andFilterWhere(['LIKE', 'dependNomorDokumen', $this->dependNomorDokumen]);


      return $dataProvider;

   }

   /**
    * @return Query
    */
   public function getQuery(): Query
   {
      $query = $this->getInitStartProject()
         ->union($this->getTandaTerimaBarang(), true)
         ->union($this->getClaimPettyCash(), true)
         ->union($this->getDeliveryReceipt(), true)
         ->union($this->getTransferOut(), true)
         ->union($this->getTransferIn(), true);

      return (new Query())
         ->from([
            'history' => $query
         ]);
   }

   /**
    * @return Query
    */
   protected function getInitStartProject(): Query
   {
      $statusId = TipePergerakanBarangEnum::getStatus(TipePergerakanBarangEnum::START_PERTAMA_KALI_PENERAPAN_SISTEM)->id;
      return (new Query())
         ->select([
            'b.id as id',
            'type' => new Expression(":typeInit", [':typeInit' => HistoryLokasiBarang::HISTORY_INIT_TYPE]),
            'b.part_number as partNumber',
            'b.ift_number as kodeBarang',
            'b.nama as namaBarang',
            'b.merk_part_number as merk',
            'b.id as dependId',
            'dependNomorDokumen' => new Expression("NULL"),
            'b.initialize_stock_quantity as dependQuantityDokumen',
            'hlb.nomor as nomorHistory',
            'hlb.quantity as quantityHistoryLokasi',
            'c.id as gudangId',
            'c.nama as gudang',
            'block',
            'rak',
            'tier',
            'row',
         ])
         ->from('barang b')
         ->leftJoin('history_lokasi_barang hlb', 'b.id = hlb.barang_id')
         ->leftJoin('card c', 'hlb.card_id = c.id')
         ->where([
            'b.id' => $this->barang->id,
            'hlb.tipe_pergerakan_id' => $statusId,
            'hlb.depend_id' => null
         ]);
   }

   /**
    * @return Query
    */
   protected function getTandaTerimaBarang(): Query
   {
      return (new Query())
         ->select([
            'b.id as id',
            'type' => new Expression(":typeTandaTerima", [':typeTandaTerima' => HistoryLokasiBarang::HISTORY_TANDA_TERIMA_BARANG_TYPE]),
            'b.part_number as partNumber',
            'b.ift_number as kodeBarang',
            'b.nama as namaBarang',
            'b.merk_part_number as merk',
            'ttb.id as dependId',
            'ttb.nomor as dependNomorDokumen',
            'mrdp.quantity_pesan as dependQuantityDokumen',
            'hlb.nomor as nomorHistory',
            'hlb.quantity as quantityHistoryLokasi',
            'c.id as gudangId',
            'c.nama as gudang',
            'block',
            'rak',
            'tier',
            'row',
         ])
         ->from('barang b')
         ->leftJoin('material_requisition_detail mrd', 'b.id = mrd.barang_id')
         ->leftJoin('material_requisition_detail_penawaran mrdp', 'mrd.id = mrdp.material_requisition_detail_id')
         ->leftJoin('tanda_terima_barang_detail ttbd', 'mrdp.id = ttbd.material_requisition_detail_penawaran_id')
         ->leftJoin('tanda_terima_barang ttb', 'ttbd.tanda_terima_barang_id = ttb.id')
         ->leftJoin('history_lokasi_barang hlb', 'ttbd.id = hlb.tanda_terima_barang_detail_id')
         ->leftJoin('card c', 'hlb.card_id = c.id')
         ->where(['b.id' => $this->barang->id])
         ->andWhere([
            'IS NOT', 'hlb.tanda_terima_barang_detail_id', NULL
         ]);

   }

   /**
    * @return Query
    */
   protected function getClaimPettyCash(): Query
   {
      return (new Query())
         ->select([
            'b.id as id',
            'type' => new Expression(":typeClaimPettyCash", [':typeClaimPettyCash' => HistoryLokasiBarang::HISTORY_CLAIM_PETTY_CASH_TYPE]),
            'b.part_number as partNumber',
            'b.ift_number as kodeBarang',
            'b.nama as namaBarang',
            'b.merk_part_number as merk',
            'cpc.id as dependId',
            'cpc.nomor as dependNomorDokumen',
            'cpcnd.quantity as dependQuantityDokumen',
            'hlb.nomor as nomorHistory',
            'hlb.quantity as quantityHistoryLokasi',
            'c.id as gudangId',
            'c.nama as gudang',
            'block',
            'rak',
            'tier',
            'row',
         ])
         ->from('barang b')
         ->leftJoin('claim_petty_cash_nota_detail cpcnd', 'b.id = cpcnd.barang_id')
         ->leftJoin('claim_petty_cash_nota cpcn', 'cpcnd.claim_petty_cash_nota_id = cpcn.id')
         ->leftJoin('claim_petty_cash cpc', 'cpcn.claim_petty_cash_id = cpc.id')
         ->leftJoin('history_lokasi_barang hlb', 'cpcnd.id = hlb.claim_petty_cash_nota_detail_id')
         ->leftJoin('card c', 'hlb.card_id = c.id')
         ->where([
            'b.id' => $this->barang->id,
         ])
         ->andWhere([
            'IS NOT', 'cpcnd.id', null
         ]);

   }

   /**
    * @return Query
    */
   protected function getDeliveryReceipt(): Query
   {
      return (new Query())
         ->select([
            'b.id as id',
            'type' => new Expression(":typeDeliveryReceipt", [':typeDeliveryReceipt' => HistoryLokasiBarang::HISTORY_DELIVERY_RECEIPT_TYPE]),
            'b.part_number as partNumber',
            'b.ift_number as kodeBarang',
            'b.nama as namaBarang',
            'b.merk_part_number as merk',
            'qb.id as dependId',
            'qdr.nomor as dependNomorDokumen',
            'qdrd.quantity as dependQuantityDokumen',
            'hlb.nomor as nomorHistory',
            'hlb.quantity as quantityHistoryLokasi',
            'c.id as gudangId',
            'c.nama as gudang',
            'block',
            'rak',
            'tier',
            'row',
         ])
         ->from('barang b')
         ->leftJoin('quotation_barang qb', 'b.id = qb.barang_id')
         ->leftJoin('quotation_delivery_receipt_detail qdrd', 'qb.id = qdrd.quotation_barang_id')
         ->leftJoin('quotation_delivery_receipt qdr', 'qdrd.quotation_delivery_receipt_id = qdr.id')
         ->leftJoin('history_lokasi_barang hlb', 'qdrd.id = hlb.quotation_delivery_receipt_detail_id')
         ->leftJoin('card c', 'hlb.card_id = c.id')
         ->where([
            'b.id' => $this->barang->id,
         ])
         ->andWhere([
            'IS NOT', 'qdrd.id', null
         ]);


   }

   /**
    * @return Query
    */
   protected function getTransferOut(): Query
   {
      $statusId = TipePergerakanBarangEnum::getStatus(TipePergerakanBarangEnum::MOVEMENT_FROM)->id;
      return (new Query())
         ->select([
            'b.id as id',
            'type' => new Expression(":typeTransferOut", [':typeTransferOut' => HistoryLokasiBarang::HISTORY_TRANSFER_OUT_TYPE]),
            'b.part_number as partNumber',
            'b.ift_number as kodeBarang',
            'b.nama as namaBarang',
            'b.merk_part_number as merk',
            'dependId' => new Expression("NULL"),
            'dependNomorDokumen' => new Expression("NULL"),
            'dependQuantityDokumen' => new Expression("NULL"),
            'asalGudang.nomor as nomorHistory',
            'asalGudang.quantity as quantityHistoryLokasi',
            'c.id as gudangId',
            'c.nama as gudang',
            'block',
            'rak',
            'tier',
            'row',
         ])
         ->from('barang b')
         ->leftJoin('history_lokasi_barang asalGudang', 'b.id = asalGudang.barang_id')
         ->leftJoin('card c', 'asalGudang.card_id = c.id')
         ->where([
            'b.id' => $this->barang->id,
            'asalGudang.tipe_pergerakan_id' => $statusId
         ]);

   }

   /**
    * @return Query
    */
   protected function getTransferIn(): Query
   {

      $statusId = TipePergerakanBarangEnum::getStatus(TipePergerakanBarangEnum::MOVEMENT_TO)->id;

      // Dibantu oleh ChatGPT
      $query = new ActiveQuery(Barang::class); #  Barang::find();

      $query->select([
         'b.id AS id',
         'type' => new Expression(":typeTransferIn", [':typeTransferIn' => HistoryLokasiBarang::HISTORY_TRANSFER_IN_TYPE]),
         'b.part_number AS partNumber',
         'b.ift_number AS kodeBarang',
         'b.nama AS namaBarang',
         'b.merk_part_number AS merk',
         'transferIn.depend_id AS dependId',
         'transferIn.nomor_asal_gudang AS dependNomorDokumen',
         'transferIn.asalGudang_quantity AS dependQuantityDokumen',
         'transferIn.nomor_gudang_tujuan AS nomorHistory',
         'transferIn.inGudang_quantity AS quantityHistoryLokasi',
         'transferIn.card_id AS gudangId',
         'transferIn.gudang AS gudang',
         'block',
         'rak',
         'tier',
         'row',
      ]);
      $query->from(['b' => Barang::tableName()]);

      // SubQuery
      $transferIn = (new ActiveQuery(HistoryLokasiBarang::class))
         ->select([
            "'transfer_in' AS `type`",
            'asalGudang.nomor AS nomor_asal_gudang',
            'asalGudang.barang_id AS barang_id',
            'asalGudang.quantity AS asalGudang_quantity',
            'inGudang.nomor AS nomor_gudang_tujuan',
            'inGudang.card_id',
            'inGudang.block',
            'inGudang.rak',
            'inGudang.tier',
            'inGudang.row',
            'inGudang.quantity AS inGudang_quantity',
            'inGudang.depend_id',
            'c.nama AS gudang',
         ])
         ->from(['inGudang' => HistoryLokasiBarang::tableName()])
         ->leftJoin(['asalGudang' => HistoryLokasiBarang::tableName()], 'inGudang.depend_id = asalGudang.id')
         ->leftJoin(['c' => Card::tableName()], 'inGudang.card_id = c.id')
         ->where('inGudang.depend_id IS NOT NULL AND inGudang.tipe_pergerakan_id = :tipePergerakanInGudangId AND asalGudang.barang_id = :barangId', [
            ':tipePergerakanInGudangId' => $statusId,
            ':barangId' => $this->barang->id
         ]);

      $query->leftJoin(['transferIn' => $transferIn], 'transferIn.barang_id = b.id');
      return $query->where(['b.id' => $this->barang->id]);

   }
}