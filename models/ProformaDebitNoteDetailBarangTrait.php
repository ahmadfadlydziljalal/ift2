<?php

namespace app\models;

trait ProformaDebitNoteDetailBarangTrait
{
   /**
    * @return float|int
    */
   public function getProformaDebitNoteDetailBarangsBeforeDiscountSubtotal(): float|int
   {

      $total = 0;
      if (empty($this->proformaDebitNoteDetailBarangs)) {
         return $total;
      }

      foreach ($this->proformaDebitNoteDetailBarangs as $proformaDebitNoteDetailBarang) {
         /* @see ProformaDebitNoteDetailBarang::getAmountBeforeDiscount() */
         $total += $proformaDebitNoteDetailBarang->amountBeforeDiscount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getProformaDebitNoteDetailBarangsSubtotal(): float|int
   {

      $total = 0;
      if (empty($this->proformaDebitNoteDetailBarangs)) {
         return $total;
      }

      foreach ($this->proformaDebitNoteDetailBarangs as $proformaDebitNoteDetailBarang) {
         $total += $proformaDebitNoteDetailBarang->amount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getProformaDebitNoteDetailBarangsDiscount(): float|int
   {
      if (empty($this->proformaDebitNoteDetailBarangs)) {
         return 0;
      }

      $total = 0;
      foreach ($this->proformaDebitNoteDetailBarangs as $proformaDebitNoteDetailBarang) {
         $total += $proformaDebitNoteDetailBarang->quantity * $proformaDebitNoteDetailBarang->nominalDiscount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getProformaDebitNoteDetailBarangsDasarPengenaanPajak(): float|int
   {
      return $this->proformaDebitNoteDetailBarangsSubtotal + $this->quotation->delivery_fee;
   }

   /**
    * @return float|int
    */
   public function getProformaDebitNoteDetailBarangsTotalVatNominal(): float|int
   {
      if (empty($this->proformaDebitNoteDetailBarangs)) {
         return 0;
      }
      return $this->proformaDebitNoteDetailBarangsDasarPengenaanPajak * ($this->quotation->vat_percentage / 100);
   }

   /**
    * @return float|int
    */
   public function getProformaDebitNoteDetailBarangsTotal(): float|int
   {
      return $this->proformaDebitNoteDetailBarangsDasarPengenaanPajak
         + $this->proformaDebitNoteDetailBarangsTotalVatNominal;
   }

}