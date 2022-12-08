<?php

namespace app\models;

use app\enums\DeliveryReceiptEnum;
use app\enums\SVGIconEnum;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

trait QuotationDeliveryReceiptTrait
{
   public function getListDeliveryReceiptDetails(): ActiveQuery
   {
      return $this->getQuotationDeliveryReceiptDetails()
         ->select([
            'barangNama' => 'barang.nama',
            'quotationBarangQuantity' => 'quotation_barang.quantity',
            'quantity' => new Expression("SUM(quotation_delivery_receipt_detail.quantity)"),
            'totalQuantityIndent' => new Expression("(quotation_barang.quantity) - (SUM(quotation_delivery_receipt_detail.quantity))"),
         ])
         ->joinWith(['quotationBarang' => function ($qb) {
            $qb->joinWith('barang');
         }], false)
         ->groupBy('quotation_barang_id');
   }

   /**
    * @return ActiveQuery
    */
   public function getQuotationDeliveryReceiptDetails(): ActiveQuery
   {
      return $this->hasMany(QuotationDeliveryReceiptDetail::class, ['quotation_delivery_receipt_id' => 'id'])
         ->via('quotationDeliveryReceipts');
   }

   /**
    * @return string
    */
   public function getGlobalStatusDeliveryReceiptInHtmlFormat(): string
   {
      return $this->getGlobalStatusDeliveryReceipt()
         ? Html::tag('span', SVGIconEnum::CHECK->value . ' ' . DeliveryReceiptEnum::COMPLETED->value, [
            'class' => 'badge bg-primary',
            'title' => $this->nomor
         ])
         : Html::tag('span', SVGIconEnum::X->value . ' ' . DeliveryReceiptEnum::NOT_COMPLETED->value, [
            'class' => 'badge bg-danger'
         ]);
   }

   public function getGlobalStatusDeliveryReceipt(): bool
   {
      $totalIndents = ArrayHelper::getColumn($this->listDeliveryReceiptDetails, 'totalQuantityIndent');

      $status = true;
      foreach ($totalIndents as $indent) {
         if ($indent > 0) {
            $status = false;
         }
      }
      return $status;
   }

}