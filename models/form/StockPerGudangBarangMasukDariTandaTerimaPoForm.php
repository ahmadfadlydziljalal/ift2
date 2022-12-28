<?php

namespace app\models\form;

use app\enums\SessionSetFlashEnum;
use app\enums\TextLinkEnum;
use app\enums\TipePergerakanBarangEnum;
use app\models\HistoryLokasiBarang;
use app\models\TandaTerimaBarang;
use app\models\TandaTerimaBarangDetail;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\helpers\Html;
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
   protected $nomorHistoryLokasiBarang;

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

         $nomor = HistoryLokasiBarang::generateNomor(TipePergerakanBarangEnum::IN->value);

         foreach ($this->tandaTerimaBarangDetails as $i => $tandaTerimaBarangDetail) :
            if (isset($this->historyLokasiBarangs[$i]) && is_array($this->historyLokasiBarangs[$i])) {
               if ($flag === false) break;
               foreach ($this->historyLokasiBarangs[$i] as $modelDetailDetail) {
                  $modelDetailDetail->nomor = $nomor;
                  $modelDetailDetail->tanda_terima_barang_detail_id = $tandaTerimaBarangDetail->id;
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
            Yii::$app->session->setFlash('success', [[
               'title' => 'Lokasi in berhasil di record.',
               'message' => 'Lokasi tanda terima berhasil disimpan dengan nomor referensi ' .
                  Html::tag('span', $this->getNomorHistoryLokasiBarang(), ['class' => 'badge bg-primary']),
               'footer' => Html::a(TextLinkEnum::PRINT->value,
                  ['stock-per-gudang/print-barang-masuk-tanda-terima-po', 'id' => $this->tandaTerimaBarang->id],
                  [
                     'target' => '_blank',
                     'class' => 'btn btn-primary'
                  ]
               )
            ]]);
            break;

         case SessionSetFlashEnum::DANGER->value:
            Yii::$app->session->setFlash('error', [['title' => 'Gagal', 'message' => 'Please check again ...!']]);
            break;

         default:
            throw new ServerErrorHttpException($key . ' tidak ada di setFlash.');

      endswitch;

   }

   public function getNomorHistoryLokasiBarang()
   {
      return $this->nomorHistoryLokasiBarang;
   }

}