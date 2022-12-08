<?php

namespace app\models;

trait QuotationServiceTrait
{
   /**
    * @return float|int
    */
   public function getQuotationServicesDiscount(): float|int
   {

      $total = 0;
      if (empty($this->quotationServices)) {
         return $total;
      }

      foreach ($this->quotationServices as $quotationService) {
         $total += $quotationService->hours * $quotationService->nominalDiscount;
      }

      return $total;
   }

   public function getQuotationServicesDasarPengenaanPajak(): float|int
   {
      $total = 0;
      if (empty($this->quotationServices)) {
         return $total;
      }

      foreach ($this->quotationServices as $quotationService) {
         $total += $quotationService->amount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getQuotationServicesTotalVatNominal(): float|int
   {
      if (empty($this->quotationServices)) {
         return 0;
      }

      return $this->quotationServicesDasarPengenaanPajak * ($this->vat_percentage / 100);

   }

   /**
    * @return float|int
    */
   public function getQuotationServicesTotal(): float|int
   {
      return $this->quotationServicesDasarPengenaanPajak
         + $this->quotationServicesTotalVatNominal;
   }

   public function getQuotationServicesBeforeDiscountDasarPengenaanPajak(): float|int
   {
      $total = 0;
      if (empty($this->quotationServices)) {
         return $total;
      }

      foreach ($this->quotationServices as $quotationService) {
         $total += $quotationService->getAmountBeforeDiscount();
      }

      return $total;
   }
}