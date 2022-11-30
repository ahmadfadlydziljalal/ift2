<?php

namespace app\models\form;

use app\models\QuotationDeliveryReceiptDetail;
use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\db\Query;

class LaporanOutgoingQuotation extends Model
{ 

   public ?string $tanggal = null;

   public function rules(): array
   {
      return [
         ['tanggal', 'required']
      ];
   }

   public function getData(): array
   {

      $hasIn = QuotationDeliveryReceiptDetail::find()
         ->select([
            'quotation_barang_id',
            'totalQuantityIndent' => new Expression('(COALESCE(quotation_barang.quantity, 0)) - COALESCE(SUM(quotation_delivery_receipt_detail.quantity), 0)')
         ])
         ->joinWith('quotationDeliveryReceipt')
         ->joinWith(['quotationBarang'])
         ->where([
            '<=', 'quotation_delivery_receipt.tanggal', Yii::$app->formatter->asDate($this->tanggal, "php:Y-m-d")
         ])
         ->groupBy('quotation_barang_id');

      $master = QuotationDeliveryReceiptDetail::find()
         ->select([
            'barangNama' => 'barang.nama',
            'satuanNama' => 'satuan.nama',
            'quotation_barang_id',
            'quotationBarangQuantity' => 'quotation_barang.quantity',
            'quantity' => new Expression("SUM(quotation_delivery_receipt_detail.quantity)"),
         ])
         ->joinWith('quotationDeliveryReceipt')
         ->joinWith(['quotationBarang' => function ($qb) {
            $qb->joinWith('barang');
            $qb->joinWith('satuan');
         }])
         ->where([
            'quotation_delivery_receipt.tanggal' => Yii::$app->formatter->asDate($this->tanggal, "php:Y-m-d")
         ])
         ->groupBy('quotation_barang_id');

      $query = (new Query())
         ->from([
            'master' => $master
         ])
         ->leftJoin(['hasIn' => $hasIn], 'master.quotation_barang_id = hasIn.quotation_barang_id');

      return $query->all();


   }


}