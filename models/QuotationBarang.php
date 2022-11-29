<?php

namespace app\models;

use app\models\base\QuotationBarang as BaseQuotationBarang;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "quotation_barang".
 * @property $labelIsVat string
 * @property $nominalDiscount float | int
 * @property $unitPriceAfterDiscount float | int
 * @property $amount float | int
 * @property $amountBeforeDiscount float | int
 */
class QuotationBarang extends BaseQuotationBarang
{

   public ?string $namaBarang = null;
   public ?float $totalQuantityBarangDalamQuotation = null;
   public ?float $totalQuantityBarangSudahDikirim = null;

   public function behaviors(): array
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
         ]
      );
   }

   public function rules(): array
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
            ['discount', 'default', 'value' => 0],
            ['is_vat', 'default', 'value' => 1],
         ]
      );
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels(): array
   {
      return [
         'id' => 'ID',
         'quotation_id' => 'Quotation ID',
         'barang_id' => 'Barang',
         'stock' => 'Stock',
         'quantity' => 'Quantity',
         'satuan_id' => 'Satuan',
         'unit_price' => 'Unit Price',
         'discount' => 'Discount',
         'is_vat' => 'Is Vat',
      ];
   }

   /**
    * @return string
    */
   public function getLabelIsVat(): string
   {
      return empty($this->is_vat)
         ? Html::tag('span', 'NO V.A.T', ['class' => 'badge bg-secondary'])
         : Html::tag('span', 'V.A.T', ['class' => 'badge bg-info']);
   }

   /**
    * @return float|int
    */
   public function getNominalDiscount(): float|int
   {
      if ($this->discount) {
         return $this->unit_price * ($this->discount / 100);
      }

      return 0;
   }

   /**
    * @return string
    */
   public function getUnitPriceAfterDiscount(): string
   {
      return ((float)$this->unit_price) - ((float)$this->nominalDiscount);
   }


   /**
    * @return float|int
    */
   public function getAmountBeforeDiscount(): float|int
   {
      return $this->quantity * $this->unit_price;
   }

   /**
    * @return float|int
    */
   public function getAmount(): float|int
   {
      return ($this->quantity * $this->unitPriceAfterDiscount);
   }

   /**
    * @param int $quotationBarangId
    * @return bool|int|mixed|string|null
    */
   public function totalQuantitySudahTerkirimSpecificQuotationBarang(int $quotationBarangId): mixed
   {
      return parent::getQuotationDeliveryReceiptDetails()
         ->where([
            'quotation_barang_id' => $quotationBarangId
         ])
         ->sum('quantity');
   }


}