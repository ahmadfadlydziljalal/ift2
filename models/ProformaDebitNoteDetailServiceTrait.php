<?php

namespace app\models;

trait ProformaDebitNoteDetailServiceTrait
{
   public function getProformaDebitNoteDetailServicesDasarPengenaanPajak(): float|int
   {
      $total = 0;
      if (empty($this->proformaDebitNoteDetailServices)) {
         return $total;
      }

      foreach ($this->proformaDebitNoteDetailServices as $proformaDebitNoteDetailService) {
         $total += $proformaDebitNoteDetailService->amount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getProformaDebitNoteDetailServicesDiscount(): float|int
   {

      $total = 0;
      if (empty($this->proformaDebitNoteDetailServices)) {
         return $total;
      }

      foreach ($this->proformaDebitNoteDetailServices as $proformaDebitNoteDetailService) {
         $total += $proformaDebitNoteDetailService->hours * $proformaDebitNoteDetailService->nominalDiscount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getProformaDebitNoteDetailServicesTotalVatNominal(): float|int
   {
      if (empty($this->proformaDebitNoteDetailServices)) {
         return 0;
      }

      return $this->proformaDebitNoteDetailServicesDasarPengenaanPajak * ($this->quotation->vat_percentage / 100);

   }

   /**
    * @return float|int
    */
   public function getProformaDebitNoteDetailServicesTotal(): float|int
   {
      return $this->proformaDebitNoteDetailServicesDasarPengenaanPajak
         + $this->proformaDebitNoteDetailServicesTotalVatNominal;
   }

   public function getProformaDebitNoteDetailServicesBeforeDiscountDasarPengenaanPajak(): float|int
   {
      $total = 0;
      if (empty($this->proformaDebitNoteDetailServices)) {
         return $total;
      }

      foreach ($this->proformaDebitNoteDetailServices as $proformaDebitNoteDetailService) {
         $total += $proformaDebitNoteDetailService->getAmountBeforeDiscount();
      }

      return $total;
   }
}