<?php

namespace app\models\form;

use app\enums\SessionSetFlashEnum;
use app\enums\TextLinkEnum;
use app\enums\TipePergerakanBarangEnum;
use app\models\ClaimPettyCash;
use app\models\ClaimPettyCashNotaDetail;
use app\models\HistoryLokasiBarang;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\Html;
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

   # string
   protected string $nomorHistoryLokasiBarang;

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
         $nomor = HistoryLokasiBarang::generateNomor(TipePergerakanBarangEnum::IN->value);

         /** @var ClaimPettyCashNotaDetail $claimPettyCashDetail */
         foreach ($this->claimPettyCashNotaDetails as $i => $claimPettyCashDetail) :

            if ($flag === false) break;

            if (isset($this->historyLokasiBarangs[$i]) && is_array($this->historyLokasiBarangs[$i])) {
               foreach ($this->historyLokasiBarangs[$i] as $modelDetailDetail) {
                  $modelDetailDetail->nomor = $nomor;
                  $modelDetailDetail->claim_petty_cash_nota_detail_id = $claimPettyCashDetail->id;
                  if (!($flag = $modelDetailDetail->save(false))) {
                     break;
                  }
               }
            }

         endforeach;

         if ($flag) {
            $transaction->commit();

            $this->nomorHistoryLokasiBarang = $nomor;
            $this->flashMessage(SessionSetFlashEnum::SUCCESS->value);

            return true;
         }
         $transaction->rollBack();

      } catch (Exception $e) {

         $transaction->rollBack();
         throw new ServerErrorHttpException("Database tidak bisa menyimpan data karena " . $e->getMessage());
      }

      $this->flashMessage(SessionSetFlashEnum::DANGER->value);
      return false;
   }

   /**
    * @param string $key
    * @return void
    * @throws ServerErrorHttpException
    */
   protected function flashMessage(string $key = ''): void
   {
      switch ($key) :

         case SessionSetFlashEnum::SUCCESS->value:
            Yii::$app->session->setFlash($key, [[
               'title' => 'Lokasi in berhasil di record.',
               'message' => 'Lokasi Claim Petty Cash berhasil disimpan dengan nomor referensi ' . Html::tag('span', $this->nomorHistoryLokasiBarang, ['class' => 'badge bg-primary']),
               'footer' => Html::a(TextLinkEnum::PRINT->value,
                  ['stock-per-gudang/print-barang-masuk-claim-petty-cash', 'id' => $this->claimPettyCash->id],
                  [
                     'target' => '_blank',
                     'class' => 'btn btn-primary'
                  ]
               )
            ]]);
            break;

         case SessionSetFlashEnum::DANGER->value:
            Yii::$app->session->setFlash('error', [[
               'title' => 'Gagal',
               'message' => 'Please check again ...!'
            ]]);
            break;

         default:
            throw new ServerErrorHttpException($key . ' tidak ada di setFlash.');

      endswitch;

   }

   /**
    * @return string
    */
   public function getNomorHistoryLokasiBarang(): string
   {
      return $this->nomorHistoryLokasiBarang;
   }


}