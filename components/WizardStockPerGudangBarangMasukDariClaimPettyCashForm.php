<?php

namespace app\components;

use app\components\helpers\ArrayHelper;
use app\models\ClaimPettyCashNotaDetail;
use app\models\form\StockPerGudangBarangMasukDariClaimPettyCashForm;
use app\models\HistoryLokasiBarang;
use app\models\Status;
use app\models\Tabular;
use Yii;
use yii\base\Component;
use yii\web\ServerErrorHttpException;

class WizardStockPerGudangBarangMasukDariClaimPettyCashForm extends Component
{
   public ?StockPerGudangBarangMasukDariClaimPettyCashForm $model = null;

   /**
    * @var ClaimPettyCashNotaDetail[]
    * */
   public ?array $modelsDetail = null;
   public ?array $modelsDetailDetail = null;

   public function init()
   {
      parent::init();

      if ($this->model->scenario == StockPerGudangBarangMasukDariClaimPettyCashForm::SCENARIO_STEP_2):

         $this->modelsDetail = $this->model->claimPettyCash->claimPettyCashNotaDetailsHaveStockType;

         $this->modelsDetailDetail = [];
         foreach ($this->modelsDetail as $i => $detail) {
            $this->modelsDetailDetail[$i][] = new HistoryLokasiBarang([
               'claim_petty_cash_nota_detail_id' => $detail->id,
            ]);
         }

      endif;
   }


   /**
    * @throws ServerErrorHttpException
    */
   public function save(): bool
   {
      $this->modelsDetail = Tabular::createMultiple(ClaimPettyCashNotaDetail::class, $this->modelsDetail);

      Tabular::loadMultiple($this->modelsDetail, Yii::$app->request->post());
      $this->model->claimPettyCashNotaDetails = $this->modelsDetail;

      $isValid = true;
      if (isset($_POST['HistoryLokasiBarang'][0][0])) {

         foreach ($_POST['HistoryLokasiBarang'] as $i => $historyLokasiBarangs) {
            foreach ($historyLokasiBarangs as $j => $historyLokasiBarang) {
               $data['HistoryLokasiBarang'] = $historyLokasiBarang;

               $modelHistoryLokasiBarang = new HistoryLokasiBarang();
               $modelHistoryLokasiBarang->load($data);

               $modelHistoryLokasiBarang->tipe_pergerakan_id = Status::findOne([
                  'section' => Status::SECTION_SET_LOKASI_BARANG,
                  'key' => 'in'
               ])->id;

               $modelHistoryLokasiBarang->step = 0;

               $this->modelsDetailDetail[$i][$j] = $modelHistoryLokasiBarang;
               $isValid = $modelHistoryLokasiBarang->validate() && $isValid;
            }
         }

         /** @var ClaimPettyCashNotaDetail $item */
         foreach ($this->modelsDetail as $indexDetail => $item) {
            $item->scenario = ClaimPettyCashNotaDetail::SCENARIO_INPUT_KE_GUDANG;
            $item->totalQuantityTerimaPerbandiganLokasi = array_sum(
               ArrayHelper::getColumn($this->modelsDetailDetail[$indexDetail], 'quantity')
            );
         }
      }

      $this->model->historyLokasiBarangs = $this->modelsDetailDetail;
      $isValid = $this->model->validate() && $isValid;
      $isValid = Tabular::validateMultiple($this->modelsDetail) && $isValid;

      if ($isValid) {
         if ($this->model->save())
            return true;

      }

      return false;
   }

}