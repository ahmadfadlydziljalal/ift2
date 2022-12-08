<?php

namespace app\models;

use app\models\base\ProformaDebitNote as BaseProformaDebitNote;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "proforma_debit_note".
 */
class ProformaDebitNote extends BaseProformaDebitNote
{

   use ProformaDebitNoteDetailBarangTrait;
   use ProformaDebitNoteDetailServiceTrait;

   const SCENARIO_CREATE_PROFORMA_DEBIT_NOTE_DETAIL_BARANG = 'create-proforma-debit-note-detail-barang';
   const SCENARIO_UPDATE_PROFORMA_DEBIT_NOTE_DETAIL_BARANG = 'update-proforma-debit-note-detail-barang';
   const SCENARIO_CREATE_PROFORMA_DEBIT_NOTE_DETAIL_SERVICE = 'create-proforma-debit-note-detail-service';
   const SCENARIO_UPDATE_PROFORMA_DEBIT_NOTE_DETAIL_SERVICE = 'update-proforma-debit-note-details-service';


   public ?array $modelsProformaDebitNoteDetailsBarang = null;
   public ?array $deletedProformaDebitNoteDetailsBarangId = null;
   public ?array $modelsProformaDebitNoteDetailsService = null;
   public ?array $deletedProformaDebitNoteDetailsServiceId = null;

   public function behaviors(): array
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
            [
               'class' => 'mdm\autonumber\Behavior',
               'attribute' => 'nomor', // required
               'value' => '?' . '/IFTJKT/DN/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
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

   public function getPph23Label(): string
   {
      return $this->pph_23_percent . ' %';
   }

   public function createModelsProformaDebitNoteDetailBarang(): bool
   {
      $transaction = self::getDb()->beginTransaction();

      try {

         $flag = true;

         /** @var ProformaDebitNoteDetailBarang $detail */
         foreach ($this->modelsProformaDebitNoteDetailsBarang as $detail) {

            $detail->proforma_debit_note_id = $this->id;
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
   public function updateModelsProformaDebitNoteDetailBarang(): bool
   {
      $transaction = self::getDb()->beginTransaction();
      try {

         $flag = true;

         if (!empty($this->deletedProformaDebitNoteDetailsBarangId)) {
            $flag = ProformaDebitNote::deleteAll(['id' => $this->deletedProformaDebitNoteDetailsBarangId]);
         }

         if ($flag) {
            /** @var ProformaDebitNoteDetailBarang $detail */
            foreach ($this->modelsProformaDebitNoteDetailsBarang as $detail) {

               $detail->proforma_debit_note_id = $this->id;
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

   public function createModelsProformaDebitNoteDetailService(): bool
   {


      $transaction = self::getDb()->beginTransaction();

      try {

         $flag = true;

         /** @var ProformaDebitNoteDetailService $detail */
         foreach ($this->modelsProformaDebitNoteDetailsService as $detail) {

            $detail->proforma_debit_note_id = $this->id;
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
   public function updateModelsProformaDebitNoteDetailService(): bool
   {
      $transaction = self::getDb()->beginTransaction();
      try {

         $flag = true;

         if (!empty($this->deletedProformaDebitNoteDetailsServiceId)) {
            $flag = ProformaDebitNoteDetailService::deleteAll(['id' => $this->deletedProformaDebitNoteDetailsServiceId]);
         }

         if ($flag) {
            /** @var ProformaDebitNoteDetailService $detail */
            foreach ($this->modelsProformaDebitNoteDetailsService as $detail) {

               $detail->proforma_debit_note_id = $this->id;
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

   public function getProformaDebitNoteGrandTotal(): float|int
   {
      return $this->proformaDebitNoteDetailServicesTotal + $this->quotation->materai_fee + $this->proformaDebitNoteDetailBarangsTotal;
   }

   public function getProformaDebitNoteVatTotal()
   {
      return $this->proformaDebitNoteDetailBarangsTotalVatNominal + $this->proformaDebitNoteDetailServicesTotalVatNominal;
   }

   public function getProformaDebitNoteFeeTotal()
   {
      return
         $this->quotation->delivery_fee +
         $this->proformaDebitNoteDetailBarangsBeforeDiscountSubtotal +
         $this->proformaDebitNoteDetailServicesBeforeDiscountDasarPengenaanPajak +
         $this->quotation->materai_fee;
   }

   public function getProformaDebitNoteDiscountTotal()
   {
      return
         $this->proformaDebitNoteDetailBarangsDiscount +
         $this->proformaDebitNoteDetailServicesDiscount;
   }

   public function getPenerimaan()
   {
      return $this->proformaDebitNoteGrandTotal - $this->getPph23Nominal();
   }

   public function getPph23Nominal(): float|int
   {
      return ($this->pph_23_percent / 100) * $this->proformaDebitNoteDetailServicesDasarPengenaanPajak;
   }

}