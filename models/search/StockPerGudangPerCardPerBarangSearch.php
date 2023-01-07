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

class StockPerGudangPerCardPerBarangSearch extends HistoryLokasiBarang
{

   const HISTORY_INIT_TYPE = 'init_start_project';
   const HISTORY_TANDA_TERIMA_BARANG_TYPE = 'tanda_terima_barang';
   const HISTORY_CLAIM_PETTY_CASH_TYPE = 'claim_petty_cash';
   const HISTORY_DELIVERY_RECEIPT_TYPE = 'delivery_receipt';
   const HISTORY_TRANSFER_OUT_TYPE = 'transfer_out';
   const HISTORY_TRANSFER_IN_TYPE = 'transfer_in';

   public ?Card $card = null;
   public ?Barang $barang = null;

   /**
    * bypass scenarios() implementation in the parent class
    * @return array
    */
   public function scenarios(): array
   {
      return Model::scenarios();
   }

   public function rules(): array
   {
      return [
         [['block', 'rak', 'tier', 'row'], 'safe']
      ];
   }

   public function search($params): ActiveDataProvider
   {
      $query = $this->getQuery();
      $dataProvider = new ActiveDataProvider([
         'query' => $query,
         'key' => 'barang_id',
      ]);

      $this->load($params);

      if (!$this->validate()) {
         return $dataProvider;
      }

      $query->andFilterWhere([
         'block' => $this->block,
         'rak' => $this->rak,
         'tier' => $this->tier,
         'row' => $this->row,
      ]);

      return $dataProvider;
   }

   /**
    * @return Query
    */
   public function getQuery(): Query
   {
      $query = $this->getHistoryLokasiBarangInitStartProject()
         ->union($this->getHistoryLokasiBarangTandaTerimaBarang())
         ->union($this->getHistoryLokasiBarangClaimPettyCash())
         ->union($this->getHistoryLokasiBarangDeliveryReceipt())
         ->union($this->getHistoryLokasiBarangTransferOut())
         ->union($this->getHistoryLokasiBarangTransferIn());

      $qtyInit = new Expression("SUM(IF(history.type = :type1, quantity, 0)) ", ['type1' => self::HISTORY_INIT_TYPE]);
      $qtyTandaTerimaBarang = new Expression("SUM(IF(history.type = :type2, quantity, 0)) ", ['type2' => self::HISTORY_TANDA_TERIMA_BARANG_TYPE]);
      $qtyClaimPettyCash = new Expression("SUM(IF(history.type = :type3, quantity, 0)) ", ['type3' => self::HISTORY_CLAIM_PETTY_CASH_TYPE]);
      $qtyDeliveryReceipt = new Expression("SUM(IF(history.type = :type4, quantity, 0)) ", ['type4' => self::HISTORY_DELIVERY_RECEIPT_TYPE]);
      $qtyTransferOut = new Expression("SUM(IF(history.type = :type5, quantity, 0)) ", ['type5' => self::HISTORY_TRANSFER_OUT_TYPE]);
      $qtyTransferIn = new Expression("SUM(IF(history.type = :type6, quantity, 0)) ", ['type6' => self::HISTORY_TRANSFER_IN_TYPE]);

      return (new Query())
         ->select("
             history.barang_id,
             history.card_id,
             history.block,
             history.rak,
             history.tier,
             history.row
         ")
         ->addSelect([
            'qtyInit' => $qtyInit,
            'qtyTandaTerimaBarang' => $qtyTandaTerimaBarang,
            'qtyClaimPettyCash' => $qtyClaimPettyCash,
            'qtyDeliveryReceipt' => $qtyDeliveryReceipt,
            'qtyTransferOut' => $qtyTransferOut,
            'qtyTransferIn' => $qtyTransferIn,
         ])
         ->addSelect([
            'qtyFinal' => new Expression(
               $qtyInit
               . "+" . $qtyTandaTerimaBarang
               . "+" . $qtyClaimPettyCash
               . "-" . $qtyDeliveryReceipt
               . "-" . $qtyTransferOut
               . "+" . $qtyTransferIn
            )
         ])
         ->from([
            'history' => $query
         ])
         ->groupBy('history.card_id, history.barang_id, history.block, history.rak, history.tier, history.row')
         ->orderBy('history.block, history.rak, history.tier, history.row');
   }

   /**
    * @return ActiveQuery
    */
   protected function getHistoryLokasiBarangInitStartProject(): ActiveQuery
   {
      $statusId = TipePergerakanBarangEnum::getStatus(TipePergerakanBarangEnum::START_PERTAMA_KALI_PENERAPAN_SISTEM)->id;
      return HistoryLokasiBarang::find()
         ->select([
            'type' => new Expression(":typeInit", [':typeInit' => self::HISTORY_INIT_TYPE]),
            'barang_id',
            'card_id',
            'block',
            'rak',
            'tier',
            'row',
            'quantity' => new Expression("SUM(quantity)")
         ])
         ->alias('hlb')
         ->where('card_id = :cardId', [':cardId' => $this->card->id])
         ->andWhere('barang_id = :barangId', [':barangId' => $this->barang->id])
         ->andWhere('hlb.tipe_pergerakan_id = :tipePergerakanId', [':tipePergerakanId' => $statusId])
         ->andWhere(['IS', 'hlb.depend_id', NULL])
         ->groupBy(['block', 'rak', 'tier', 'row',]);
   }

   /**
    * @return ActiveQuery
    */
   protected function getHistoryLokasiBarangTandaTerimaBarang(): ActiveQuery
   {
      return HistoryLokasiBarang::find()
         ->select([
            'type' => new Expression(":typeTandaTerima", [':typeTandaTerima' => self::HISTORY_TANDA_TERIMA_BARANG_TYPE]),
            'barang_id' => new Expression('mrd.barang_id'),
            'card_id',
            'block',
            'rak',
            'tier',
            'row',
            'quantity' => new Expression("SUM(hlb.quantity)")
         ])
         ->alias('hlb')
         ->joinWith(['tandaTerimaBarangDetail' => fn($ttbd) => $ttbd->alias('ttbd')
            ->joinWith(['materialRequisitionDetailPenawaran' => fn($mrdp) => $mrdp->alias('mrdp')
               ->joinWith(['materialRequisitionDetail' => fn($mrd) => $mrd->alias('mrd')])
            ])
         ])
         ->where(['hlb.card_id' => $this->card->id])
         ->andWhere(['mrd.barang_id' => $this->barang->id])
         ->andWhere(['IS NOT', 'ttbd.id', NULL])
         ->groupBy(['block', 'rak', 'tier', 'row',]);
   }

   /**
    * @return ActiveQuery
    */
   protected function getHistoryLokasiBarangClaimPettyCash(): ActiveQuery
   {
      return HistoryLokasiBarang::find()
         ->select([
            'type' => new Expression(":typeClaimPettyCash", [':typeClaimPettyCash' => self::HISTORY_CLAIM_PETTY_CASH_TYPE]),
            'barang_id' => new Expression('cpcnd.barang_id'),
            'card_id',
            'block',
            'rak',
            'tier',
            'row',
            'quantity' => new Expression("SUM(hlb.quantity)")
         ])
         ->alias('hlb')
         ->joinWith(['claimPettyCashNotaDetail' => fn($cpcnd) => $cpcnd->alias('cpcnd')])
         ->where(['hlb.card_id' => $this->card->id])
         ->andWhere(['cpcnd.barang_id' => $this->barang->id])
         ->andWhere(['IS NOT', 'cpcnd.id', NULL])
         ->groupBy(['block', 'rak', 'tier', 'row',]);
   }

   /**
    * @return ActiveQuery
    */
   protected function getHistoryLokasiBarangDeliveryReceipt(): ActiveQuery
   {
      return HistoryLokasiBarang::find()
         ->select([
            'type' => new Expression(":typeDeliveryReceipt", [':typeDeliveryReceipt' => self::HISTORY_DELIVERY_RECEIPT_TYPE]),
            'barang_id' => new Expression('qb.barang_id'),
            'card_id',
            'block',
            'rak',
            'tier',
            'row',
            'quantity' => new Expression("SUM(hlb.quantity)")
         ])
         ->alias('hlb')
         ->joinWith(['quotationDeliveryReceiptDetail' => fn($qdrd) => $qdrd->alias('qdrd')
            ->joinWith(['quotationBarang' => fn($qb) => $qb->alias('qb')])
         ])
         ->where(['hlb.card_id' => $this->card->id])
         ->andWhere(['qb.barang_id' => $this->barang->id])
         ->andWhere(['IS NOT', 'qdrd.id', NULL])
         ->groupBy(['block', 'rak', 'tier', 'row',]);
   }

   /**
    * @return ActiveQuery
    */
   protected function getHistoryLokasiBarangTransferOut(): ActiveQuery
   {
      $statusId = TipePergerakanBarangEnum::getStatus(TipePergerakanBarangEnum::MOVEMENT_FROM)->id;
      return HistoryLokasiBarang::find()
         ->alias('asalGudang')
         ->select([
            'type' => new Expression(":typeTransferOut", [':typeTransferOut' => self::HISTORY_TRANSFER_OUT_TYPE]),
            'asalGudang.barang_id',
            'asalGudang.card_id',
            'asalGudang.block',
            'asalGudang.rak',
            'asalGudang.tier',
            'asalGudang.row',
            'SUM(asalGudang.quantity) as quantity'
         ])
         ->where([
            'asalGudang.card_id' => $this->card->id,
            'asalGudang.tipe_pergerakan_id' => $statusId,
            'asalGudang.barang_id' => $this->barang->id
         ])
         ->groupBy([
            'asalGudang.block',
            'asalGudang.rak',
            'asalGudang.tier',
            'asalGudang.row'
         ]);
   }

   /**
    * @return ActiveQuery
    */
   protected function getHistoryLokasiBarangTransferIn(): ActiveQuery
   {
      $statusId = TipePergerakanBarangEnum::getStatus(TipePergerakanBarangEnum::MOVEMENT_TO)->id;
      return HistoryLokasiBarang::find()
         ->alias('inGudang')
         ->select([
            'type' => new Expression(":typeTransferIn", [':typeTransferIn' => self::HISTORY_TRANSFER_IN_TYPE]),
            'asalGudang.barang_id',
            'inGudang.card_id',
            'inGudang.block',
            'inGudang.rak',
            'inGudang.tier',
            'inGudang.row',
            'SUM(inGudang.quantity) AS quantity'
         ])
         ->joinWith(['depend' => fn($asalGudang) => $asalGudang->alias('asalGudang')])
         ->where([
            'inGudang.card_id' => $this->card->id,

            'inGudang.tipe_pergerakan_id' => $statusId,
            'asalGudang.barang_id' => $this->barang->id
         ])
         ->andWhere([
            'IS NOT', 'inGudang.depend_id', NULL,
         ])
         ->groupBy([
            'inGudang.block',
            'inGudang.rak',
            'inGudang.tier',
            'inGudang.row'
         ]);

   }

}