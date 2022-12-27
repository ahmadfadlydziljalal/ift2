<?php

namespace app\models;

use app\enums\TipePergerakanBarangEnum;
use app\models\base\HistoryLokasiBarang as BaseHistoryLokasiBarang;
use mdm\autonumber\AutoNumber;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "history_lokasi_barang".
 * @property $nomorDokumenPendukung string
 */
class HistoryLokasiBarang extends BaseHistoryLokasiBarang
{

   /**
    * @param $tipePergerakanId
    * @return string
    */
   public static function generateNomor($tipePergerakanId)
   {
      $nomor = '';
      $date = date('Y-m-d');

      switch ($tipePergerakanId):
         case TipePergerakanBarangEnum::START_PERTAMA_KALI_PENERAPAN_SISTEM->value:
            $nomor = AutoNumber::generate('START-' . $date . '-' . "?", false, 3);
            break;

         case TipePergerakanBarangEnum::IN->value:
            $nomor = AutoNumber::generate('IN-' . $date . '-' . "?", false, 3);
            break;

         case TipePergerakanBarangEnum::MOVEMENT->value:
            $nomor = AutoNumber::generate('MOVEMENT-' . $date . '-' . "?", false, 3);
            break;

         case TipePergerakanBarangEnum::PEMBATALAN->value :
            $nomor = AutoNumber::generate('BATAL-' . $date . '-' . "?", false, 3);
            break;

         case TipePergerakanBarangEnum::OUT->value :

            $nomor = AutoNumber::generate('OUT-' . $date . '-' . "?", false, 3);
            break;

         default:
            break;
      endswitch;

      return $nomor;


   }

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
         ]
      );
   }

   /**
    * @inheritdoc
    */
   public function attributeLabels()
   {
      return ArrayHelper::merge(parent::attributeLabels(), [
         'id' => 'ID',
         'card_id' => 'Warehouse',
         'tanda_terima_barang_detail_id' => 'Tanda Terima Barang Detail',
         'tipe_pergerakan_id' => 'Tipe Pergerakan',
      ]);
   }

   /**
    * @return string
    */
   public function getNomorDokumenPendukung(): string
   {
      if (!empty($this->tanda_terima_barang_detail_id)):
         return $this->tandaTerimaBarangDetail->tandaTerimaBarang->nomor;
      endif;

      if (!empty($this->claim_petty_cash_nota_detail_id)):
         return $this->claimPettyCashNotaDetail->claimPettyCashNota->claimPettyCash->nomor;
      endif;

      if (!empty($this->quotation_delivery_receipt_detail_id)):
         return $this->quotationDeliveryReceiptDetail->quotationDeliveryReceipt->nomor;
      endif;

      if (!empty($this->depend_id)):
         return $this->depend->nomor;
      endif;

      if ($this->tipe_pergerakan_id = Status::findOne([
         'section' => Status::SECTION_SET_LOKASI_BARANG,
         'key' => 'movement-from'
      ])->id) :
         return $this->nomor;
      endif;

      return '';
   }
}