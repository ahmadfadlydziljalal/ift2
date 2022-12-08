<?php

namespace app\models;

trait QuotationBarangTrait
{
   /**
    * @return float|int
    */
   public function getQuotationBarangsBeforeDiscountSubtotal(): float|int
   {

      $total = 0;
      if (empty($this->quotationBarangs)) {
         return $total;
      }

      foreach ($this->quotationBarangs as $quotationBarang) {
         /* @see QuotationBarang::getAmountBeforeDiscount() */
         $total += $quotationBarang->amountBeforeDiscount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getQuotationBarangsSubtotal(): float|int
   {

      $total = 0;
      if (empty($this->quotationBarangs)) {
         return $total;
      }

      foreach ($this->quotationBarangs as $quotationBarang) {
         $total += $quotationBarang->amount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getQuotationBarangsDiscount(): float|int
   {
      if (empty($this->quotationBarangs)) {
         return 0;
      }

      $total = 0;
      foreach ($this->quotationBarangs as $quotationBarang) {
         $total += $quotationBarang->quantity * $quotationBarang->nominalDiscount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getQuotationBarangsDasarPengenaanPajak(): float|int
   {
      return $this->quotationBarangsSubtotal + $this->delivery_fee;
   }

   /**
    * @return float|int
    */
   public function getQuotationBarangsTotalVatNominal(): float|int
   {
      if (empty($this->quotationBarangs)) {
         return 0;
      }
      return $this->quotationBarangsDasarPengenaanPajak * ($this->vat_percentage / 100);
   }

   /**
    * @return float|int
    */
   public function getQuotationBarangsTotal(): float|int
   {
      return $this->quotationBarangsDasarPengenaanPajak + $this->quotationBarangsTotalVatNominal;
   }
}