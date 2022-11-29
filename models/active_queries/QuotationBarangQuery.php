<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\QuotationBarang;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\app\models\QuotationBarang]].
 *
 * @see \app\models\QuotationBarang
 */
class QuotationBarangQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return QuotationBarang|array|null
    */
   public function one($db = null): QuotationBarang|array|null
   {
      return parent::one($db);
   }

   public function byQuotationId(int $id): array
   {
      $data = parent::select([
         'id' => 'quotation_barang.id',
         'namaBarang' => new Expression("CONCAT(barang.nama, ' | ', quotation_barang.quantity , ' | ' , satuan.nama )")
      ])->where([
         'quotation_id' => $id
      ])
         ->joinWith('barang', false)
         ->joinWith('satuan', false)
         ->all();

      return ArrayHelper::map($data, 'id', 'namaBarang');
   }

   /**
    * @inheritdoc
    * @return QuotationBarang[]|array
    */
   public function all($db = null): array
   {
      return parent::all($db);
   }

   public function forCreateDeliveryReceipt(?int $quotationId): array
   {

      $expression = new Expression("
         SUM(COALESCE(quotation_delivery_receipt_detail.quantity, 0))
      ");
      $data = parent::select([
         'id' => 'quotation_barang.id',
         'totalQuantityBarangDalamQuotation' => 'quotation_barang.quantity',
         'totalQuantityBarangSudahDikirim' => $expression,
      ])->joinWith('quotationDeliveryReceiptDetails', false)
         ->where([
            'quotation_barang.quotation_id' => $quotationId
         ])
         ->groupBy([
            'quotation_barang.id',
            'totalQuantityBarangDalamQuotation'
         ])
         ->having('totalQuantityBarangDalamQuotation != totalQuantityBarangSudahDikirim');

      return $data->all();
   }
}