<?php

namespace app\models;

use app\models\base\QuotationDeliveryReceiptDetail as BaseQuotationDeliveryReceiptDetail;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "quotation_delivery_receipt_detail".
 * @property $totalQuantityIndent float|int
 */
class QuotationDeliveryReceiptDetail extends BaseQuotationDeliveryReceiptDetail
{

   public ?float $quotationBarangQuantity = null;
   public ?float $totalQuantityIndent = null;
   public ?string $barangNama = null;

   public function behaviors()
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
         ]
      );
   }

   public function rules()
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
            /* @see \app\models\QuotationDeliveryReceiptDetail::validateQuantityBetweenQuotationBarangAndReceiptDetail */
            ['quantity', 'validateQuantityBetweenQuotationBarangAndReceiptDetail']
         ]
      );
   }

   /**
    * Algoritma :
    *
    * 1. Cari model QuotationBarang berdasarkan: $this->quotation_barang_id
    * 2. Ambil nilai quantity-nya
    * 3. Cari model-model QuotationDeliveryReceiptDetail berdasarkan: $this->quotation_barang_id
    * 4. Sum kan nilai quantity nya
    * 5. Bedakan proses saat create dan update action,
    * 5.1  Bisa ditandai dengan $this->id  `if ($this->id)`, update-action, otherwise create-action
    *
    * @param $attribute
    * @param $params
    * @param $validator
    * @return void
    */
   public function validateQuantityBetweenQuotationBarangAndReceiptDetail($attribute, $params, $validator): void
   {
      $quotationBarang = QuotationBarang::findOne($this->quotation_barang_id);
      $qtyQuotationBarang = $quotationBarang->quantity;

      $quotationDeliveryReceiptDetails =
         QuotationDeliveryReceiptDetail::findAll([
            'quotation_barang_id' => $this->quotation_barang_id,
         ]);
      $qtyQuotationDeliveryReceiptDetails =
         array_sum(ArrayHelper::getColumn(
            $quotationDeliveryReceiptDetails,
            'quantity'
         ));

      $rest = $qtyQuotationBarang
         - round($qtyQuotationDeliveryReceiptDetails, 2);

      if (!$this->id) { # mode create

         if ($this->$attribute > $rest) {
            $this->addError(
               $attribute,
               'Input lebih besar dari sisa : '
               . $qtyQuotationBarang . ' - ' . Yii::$app->formatter->asDecimal($qtyQuotationDeliveryReceiptDetails, 2) . ' = ' . $rest
            );
         }
      } else { # mode update

         $x =
            $qtyQuotationDeliveryReceiptDetails -
            round(floatval($this->oldAttributes['quantity']), 2);
         $y = $x + $this->$attribute;

         if ($y > $qtyQuotationBarang) {
            $this->addError(
               $attribute,
               'Totalnya jadi ' . $y .
               ', mengakibatkan lebih dari seharusnya, yaitu ' . $qtyQuotationBarang .
               '. Lebih ' . ($y - $qtyQuotationBarang)
            );
         }
      }
   }

   public function beforeSave($insert): bool
   {
      $this->quantity_indent = $this->getTotalQuantityIndent($insert);
      return parent::beforeSave($insert);
   }

   public function getTotalQuantityIndent($insert): mixed
   {
      $query = QuotationDeliveryReceiptDetail::find()
         ->where([
            'quotation_barang_id' => $this->quotation_barang_id
         ]);

      if (!$insert) {
         $query->andWhere([
            '!=', 'id', $this->id
         ]);
      }

      $hasIn = $query->sum('quantity');
      return $this->quotationBarang->quantity
         - $hasIn
         - $this->quantity;
   }

}