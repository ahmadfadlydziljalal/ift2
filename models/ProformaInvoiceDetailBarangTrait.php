<?php

namespace app\models;

trait ProformaInvoiceDetailBarangTrait
{
   /**
    * @return float|int
    */
   public function getProformaInvoiceDetailBarangsBeforeDiscountSubtotal(): float|int
   {

      $total = 0;
      if (empty($this->proformaInvoiceDetailBarangs)) {
         return $total;
      }

      foreach ($this->proformaInvoiceDetailBarangs as $proformaInvoiceDetailBarang) {
         /* @see ProformaInvoiceDetailBarang::getAmountBeforeDiscount() */
         $total += $proformaInvoiceDetailBarang->amountBeforeDiscount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getProformaInvoiceDetailBarangsSubtotal(): float|int
   {

      $total = 0;
      if (empty($this->proformaInvoiceDetailBarangs)) {
         return $total;
      }

      foreach ($this->proformaInvoiceDetailBarangs as $proformaInvoiceDetailBarang) {
         $total += $proformaInvoiceDetailBarang->amount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getProformaInvoiceDetailBarangsDiscount(): float|int
   {
      if (empty($this->proformaInvoiceDetailBarangs)) {
         return 0;
      }

      $total = 0;
      foreach ($this->proformaInvoiceDetailBarangs as $proformaInvoiceDetailBarang) {
         $total += $proformaInvoiceDetailBarang->quantity * $proformaInvoiceDetailBarang->nominalDiscount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getProformaInvoiceDetailBarangsDasarPengenaanPajak(): float|int
   {
      return $this->proformaInvoiceDetailBarangsSubtotal + $this->quotation->delivery_fee;
   }

   /**
    * @return float|int
    */
   public function getProformaInvoiceDetailBarangsTotalVatNominal(): float|int
   {
      if (empty($this->proformaInvoiceDetailBarangs)) {
         return 0;
      }
      return $this->proformaInvoiceDetailBarangsDasarPengenaanPajak * ($this->quotation->vat_percentage / 100);
   }

   /**
    * @return float|int
    */
   public function getProformaInvoiceDetailBarangsTotal(): float|int
   {
      return $this->proformaInvoiceDetailBarangsDasarPengenaanPajak
         + $this->proformaInvoiceDetailBarangsTotalVatNominal;
   }

}