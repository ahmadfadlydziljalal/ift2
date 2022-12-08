<?php

namespace app\models;

use app\models\base\ProformaInvoice as BaseProformaInvoice;
use Exception;
use yii\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "proforma_invoice".
 * @property $proformaInvoiceDetailBarangsTotalVatNominal float|int
 * @property $proformaInvoiceDetailBarangsBeforeDiscountSubtotal float|int
 */
class ProformaInvoice extends BaseProformaInvoice
{

   use ProformaInvoiceDetailBarangTrait;
   use ProformaInvoiceDetailServiceTrait;

   const SCENARIO_CREATE_PROFORMA_INVOICE_DETAIL_BARANG = 'create-proforma-invoice-detail-barang';
   const SCENARIO_UPDATE_PROFORMA_INVOICE_DETAIL_BARANG = 'update-proforma-invoice-detail-barang';
   const SCENARIO_CREATE_PROFORMA_INVOICE_DETAIL_SERVICE = 'create-proforma-invoice-detail-service';
   const SCENARIO_UPDATE_PROFORMA_INVOICE_DETAIL_SERVICE = 'update-proforma-invoice-details-service';

   public ?array $modelsProformaInvoiceDetailsBarang = null;
   public ?array $deletedProformaInvoiceDetailsBarangId = null;
   public ?array $modelsProformaInvoiceDetailsService = null;
   public ?array $deletedProformaInvoiceDetailsServiceId = null;

   public function behaviors(): array
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
            [
               'class' => 'mdm\autonumber\Behavior',
               'attribute' => 'nomor', // required
               'value' => '?' . '/IFTJKT/INV/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
               'digit' => 4
            ],
         ]
      );
   }

   public function rules(): array
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
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
         'nomor' => 'Nomor',
         'tanggal' => 'Tanggal',
         'pph_23_percent' => '% Pph 23',
      ];
   }

   public function getPph23Label(): string
   {
      return $this->pph_23_percent . ' %';
   }

   public function getPenerimaan()
   {
      return $this->proformaInvoiceGrandTotal - $this->getPph23Nominal();
   }

   public function getPph23Nominal(): float|int
   {
      return ($this->pph_23_percent / 100) * $this->proformaInvoiceDetailServicesDasarPengenaanPajak;
   }

   /**
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function createModelsProformaInvoiceDetailBarang(): bool
   {
      $transaction = self::getDb()->beginTransaction();

      try {

         $flag = true;

         /** @var ProformaInvoiceDetailBarang $detail */
         foreach ($this->modelsProformaInvoiceDetailsBarang as $detail) {

            $detail->proforma_invoice_id = $this->id;
            $flag = $detail->save(false);
            if (!$flag) {
               break;
            }

         }

         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException($e->getMessage());
      }

      return false;
   }

   /**
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function updateModelsProformaInvoiceDetailBarang(): bool
   {
      $transaction = ProformaInvoice::getDb()->beginTransaction();
      try {

         $flag = true;

         if (!empty($this->deletedProformaInvoiceDetailsBarangId)) {
            $flag = ProformaInvoiceDetailBarang::deleteAll(['id' => $this->deletedProformaInvoiceDetailsBarangId]);
         }

         if ($flag) {
            /** @var ProformaInvoiceDetailBarang $detail */
            foreach ($this->modelsProformaInvoiceDetailsBarang as $detail) {

               $detail->proforma_invoice_id = $this->id;
               $flag = $detail->save(false);
               if (!$flag) break;

            }
         }

         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }

      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException($e->getMessage());
      }

      return false;
   }

   public function createModelsProformaInvoiceDetailService(): bool
   {


      $transaction = self::getDb()->beginTransaction();

      try {

         $flag = true;

         /** @var ProformaInvoiceDetailService $detail */
         foreach ($this->modelsProformaInvoiceDetailsService as $detail) {

            $detail->proforma_invoice_id = $this->id;
            $flag = $detail->save(false);
            if (!$flag) {
               break;
            }

         }

         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException($e->getMessage());
      }

      return false;
   }

   /**
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function updateModelsProformaInvoiceDetailService(): bool
   {
      $transaction = ProformaInvoice::getDb()->beginTransaction();
      try {

         $flag = true;

         if (!empty($this->deletedProformaInvoiceDetailsServiceId)) {
            $flag = ProformaInvoiceDetailService::deleteAll(['id' => $this->deletedProformaInvoiceDetailsServiceId]);
         }

         if ($flag) {
            /** @var ProformaInvoiceDetailService $detail */
            foreach ($this->modelsProformaInvoiceDetailsService as $detail) {

               $detail->proforma_invoice_id = $this->id;
               $flag = $detail->save(false);
               if (!$flag) break;

            }
         }

         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }

      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException($e->getMessage());
      }

      return false;
   }

   public function getProformaInvoiceGrandTotal(): float|int
   {
      return $this->proformaInvoiceDetailServicesTotal + $this->quotation->materai_fee + $this->proformaInvoiceDetailBarangsTotal;
   }

   public function getProformaInvoiceVatTotal()
   {
      return $this->proformaInvoiceDetailBarangsTotalVatNominal + $this->proformaInvoiceDetailServicesTotalVatNominal;
   }


   public function getProformaInvoiceFeeTotal()
   {
      return
         $this->quotation->delivery_fee +
         $this->proformaInvoiceDetailBarangsBeforeDiscountSubtotal +
         $this->proformaInvoiceDetailServicesBeforeDiscountDasarPengenaanPajak +
         $this->quotation->materai_fee;
   }

   public function getProformaInvoiceDiscountTotal()
   {
      return
         $this->proformaInvoiceDetailBarangsDiscount +
         $this->proformaInvoiceDetailServicesDiscount;
   }

}