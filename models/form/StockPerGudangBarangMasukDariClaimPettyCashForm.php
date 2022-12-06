<?php

namespace app\models\form;

use app\models\ClaimPettyCash;
use app\models\ClaimPettyCashNotaDetail;
use app\models\HistoryLokasiBarang;
use yii\base\Model;
use yii\db\Exception;
use yii\web\ServerErrorHttpException;

class StockPerGudangBarangMasukDariClaimPettyCashForm extends Model
{
   const SCENARIO_STEP_1 = 'step-1';
   const SCENARIO_STEP_2 = 'step-2';

   public ?int $nomorClaimPettyCashId = null;
   public ?ClaimPettyCash $claimPettyCash = null;

   /*
    * @var ClaimPettyCashNotaDetail[]
    * */
   public ?array $claimPettyCashNotaDetails = null;

   /**
    * @var HistoryLokasiBarang[] | null;
    */
   public ?array $historyLokasiBarangs = null;

   public function rules(): array
   {
      return [
         ['nomorClaimPettyCashId', 'required', 'on' => self::SCENARIO_STEP_1],
         [['historyLokasiBarangs'], 'required', 'on' => self::SCENARIO_STEP_2],
         [['claimPettyCashNotaDetails'], 'required', 'on' => self::SCENARIO_STEP_2],
      ];
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
         /** @var ClaimPettyCashNotaDetail $claimPettyCashDetail */
         foreach ($this->claimPettyCashNotaDetails as $i => $claimPettyCashDetail) :
            if ($flag === false) break;
            if (isset($this->historyLokasiBarangs[$i]) && is_array($this->historyLokasiBarangs[$i])) {
               foreach ($this->historyLokasiBarangs[$i] as $modelDetailDetail) {
                  $modelDetailDetail->claim_petty_cash_nota_detail_id = $claimPettyCashDetail->id;
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