<?php

namespace app\models\form;

use app\components\helpers\ArrayHelper;
use app\models\HistoryLokasiBarang;
use app\models\Status;
use app\models\TandaTerimaBarangDetail;
use yii\base\Model;
use yii\db\Exception;
use yii\web\ServerErrorHttpException;


class SetLokasiBarangInForm extends Model
{

   public ?Status $tipePergerakan = null;

   /**
    * @var TandaTerimaBarangDetail|null
    * */
   public ?TandaTerimaBarangDetail $tandaTerimaBarangDetail = null;

   /**
    * @var HistoryLokasiBarang[]
    * */
   public ?array $historyLokasiBarangs = null;

   public function rules(): array
   {
      return [
         [['tandaTerimaBarangDetail', 'historyLokasiBarangs', 'tipePergerakan'], 'required'],
         /** @see SetLokasiBarangInForm::validateTotalMasterDenganTotalDetail() */
         ['tandaTerimaBarangDetail', 'validateTotalMasterDenganTotalDetail']
      ];
   }

   /**
    * @param $attribute
    * @param $params
    * @param $validator
    * @return void
    */
   public function validateTotalMasterDenganTotalDetail($attribute, $params, $validator): void
   {
      $totalSeharusnya = $this->tandaTerimaBarangDetail->quantity_terima;
      $totalYangDiKeyIn = array_sum(ArrayHelper::getColumn($this->historyLokasiBarangs, 'quantity'));

      if (round($totalSeharusnya, 2) != round($totalYangDiKeyIn, 2)) {
         $this->addError($attribute, 'Total seharusnya ' . $totalSeharusnya . '. Yang di input: ' . $totalYangDiKeyIn);
      }
   }

   /**
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function save(): bool
   {
      $transaction = HistoryLokasiBarang::getDb()->beginTransaction();
      try {

         $flag = true;

         /** @var HistoryLokasiBarang $detail */
         foreach ($this->historyLokasiBarangs as $detail) {

            $detail->tanda_terima_barang_detail_id = $this->tandaTerimaBarangDetail->id;
            $detail->tipe_pergerakan_id = $this->tipePergerakan->id;

            $flag = $detail->save(false);
            if (!$flag) break;
         }

         if ($flag) {
            $transaction->commit();
            return true;
         }
         $transaction->rollBack();
      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException('Gagal save: ' . $e->getMessage());
      }
      
      return false;
   }


}