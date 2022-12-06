<?php

namespace app\models\form;

use app\models\HistoryLokasiBarang;
use app\models\TandaTerimaBarang;
use app\models\TandaTerimaBarangDetail;
use yii\base\Model;
use yii\db\Exception;
use yii\web\ServerErrorHttpException;

class StockPerGudangBarangMasukDariTandaTerimaPoForm extends Model
{

   const SCENARIO_STEP_1 = 'step-1';
   const SCENARIO_STEP_2 = 'step-2';

   public ?int $nomorTandaTerimaId = null;
   public ?float $quantityTerima = null;
   public ?TandaTerimaBarang $tandaTerimaBarang = null;

   public ?array $tandaTerimaBarangDetails = null;

   /**
    * @var HistoryLokasiBarang[] | null;
    */
   public ?array $historyLokasiBarangs = null;

   public function rules(): array
   {
      return [
         [['nomorTandaTerimaId'], 'required', 'on' => self::SCENARIO_STEP_1],
         [['historyLokasiBarangs'], 'required', 'on' => self::SCENARIO_STEP_2],
         [['tandaTerimaBarangDetails'], 'required', 'on' => self::SCENARIO_STEP_2],
         ['quantityTerima', 'validateTotalMasterDenganTotalDetail']
         //[['historyLokasiBarangs'], 'validateTotalMasterDenganTotalDetail', 'on' => self::SCENARIO_STEP_2]
      ];
   }

   public function validateTotalMasterDenganTotalDetail($attribute, $params, $validator)
   {
      /** @var TandaTerimaBarangDetail $tandaTerimaBarangDetail */
      foreach ($this->tandaTerimaBarangDetails as $i => $tandaTerimaBarangDetail) {

         //$tandaTerimaBarangDetail->validate();
         $this->addError(
            $attribute,
            'Errornya harus tampil disini sih'
         );
      }
   }

   public function scenarios(): array
   {
      $scenarios = parent::scenarios();
      $scenarios[self::SCENARIO_STEP_1] = [
         'nomorTandaTerimaId'
      ];
      $scenarios[self::SCENARIO_STEP_2] = [
         'nomorTandaTerimaId',
         'tandaTerimaBarangDetails',
         'historyLokasiBarangs',
      ];
      return $scenarios;
   }

   /**
    * @throws ServerErrorHttpException
    */
   public function save(): bool
   {
      $transaction = HistoryLokasiBarang::getDb()->beginTransaction();
      try {
         $flag = true;
         foreach ($this->tandaTerimaBarangDetails as $i => $tandaTerimaBarangDetail) :
            if ($flag === false) break;
            if (isset($this->historyLokasiBarangs[$i]) && is_array($this->historyLokasiBarangs[$i])) {
               foreach ($this->historyLokasiBarangs[$i] as $modelDetailDetail) {
                  $modelDetailDetail->tanda_terima_barang_detail_id = $tandaTerimaBarangDetail->id;
                  if (!($flag = $modelDetailDetail->save(false))) {
                     break;
                  }
               }
            }
         endforeach;

         if ($flag) {
            $transaction->commit();
            return true;
         }

         $transaction->rollBack();
      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException("Database tidak bisa menyimpan data karena " . $e->getMessage());
      }

      return false;
   }

}