<?php

namespace app\models;

trait ProformaInvoiceDetailServiceTrait
{
   public function getProformaInvoiceDetailServicesDasarPengenaanPajak(): float|int
   {
      $total = 0;
      if (empty($this->proformaInvoiceDetailServices)) {
         return $total;
      }

      foreach ($this->proformaInvoiceDetailServices as $proformaInvoiceDetailService) {
         $total += $proformaInvoiceDetailService->amount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getProformaInvoiceDetailServicesDiscount(): float|int
   {

      $total = 0;
      if (empty($this->proformaInvoiceDetailServices)) {
         return $total;
      }

      foreach ($this->proformaInvoiceDetailServices as $proformaInvoiceDetailService) {
         $total += $proformaInvoiceDetailService->hours * $proformaInvoiceDetailService->nominalDiscount;
      }

      return $total;
   }

   /**
    * @return float|int
    */
   public function getProformaInvoiceDetailServicesTotalVatNominal(): float|int
   {
      if (empty($this->proformaInvoiceDetailServices)) {
         return 0;
      }

      return $this->proformaInvoiceDetailServicesDasarPengenaanPajak * ($this->quotation->vat_percentage / 100);

   }

   /**
    * @return float|int
    */
   public function getProformaInvoiceDetailServicesTotal(): float|int
   {
      return $this->proformaInvoiceDetailServicesDasarPengenaanPajak
         + $this->proformaInvoiceDetailServicesTotalVatNominal;
   }

   public function getProformaInvoiceDetailServicesBeforeDiscountDasarPengenaanPajak(): float|int
   {
      $total = 0;
      if (empty($this->proformaInvoiceDetailServices)) {
         return $total;
      }

      foreach ($this->proformaInvoiceDetailServices as $proformaInvoiceDetailService) {
         $total += $proformaInvoiceDetailService->getAmountBeforeDiscount();
      }

      return $total;
   }
}