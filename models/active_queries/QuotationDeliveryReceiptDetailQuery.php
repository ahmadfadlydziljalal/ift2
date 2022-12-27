<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\QuotationDeliveryReceiptDetail;
use http\Exception\InvalidArgumentException;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\QuotationDeliveryReceiptDetail]].
 *
 * @see QuotationDeliveryReceiptDetail
 */
class QuotationDeliveryReceiptDetailQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return QuotationDeliveryReceiptDetail|array|null
    */
   public function one($db = null)
   {
      return parent::one($db);
   }

   public function mapBelumMasukLokasi($isGrouping = false, $columns = [])
   {
      $parent = parent::select([
         'quotation_delivery_receipt_id' => 'quotation_delivery_receipt_detail.quotation_delivery_receipt_id',
         'nomorQuotationDeliveryReceipt' => 'quotation_delivery_receipt.nomor'
      ])->joinWith('quotationDeliveryReceipt');

      if ($isGrouping === false) :
         $parent->addSelect([
            'id' => 'quotation_delivery_receipt_detail.id',
         ]);
         return ArrayHelper::map(
            $parent->all(),
            'id',
            'nomorQuotationDeliveryReceipt'
         );
      endif;

      if (!isset($columns)) {
         throw new InvalidArgumentException('Columns tidak boleh kosong');
      }

      $parent->joinWith('historyLokasiBarangs')
         ->where([
            'IS', 'history_lokasi_barang.id', NULL
         ]);

      foreach ($columns as $column) {
         $parent->addGroupBy($column);
      }

      return ArrayHelper::map(
         $parent->all(),
         'quotation_delivery_receipt_id',
         'nomorQuotationDeliveryReceipt'
      );

   }

   /**
    * @inheritdoc
    * @return QuotationDeliveryReceiptDetail[]|array
    */
   public function all($db = null)
   {
      return parent::all($db);
   }
}