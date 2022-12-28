<?php

namespace app\components;

use app\components\helpers\ArrayHelper;
use app\models\form\StockPerGudangBarangMasukDariTandaTerimaPoForm;
use app\models\HistoryLokasiBarang;
use app\models\Status;
use app\models\Tabular;
use app\models\TandaTerimaBarangDetail;
use Yii;
use yii\base\Component;
use yii\web\ServerErrorHttpException;

class WizardStockPerGudangBarangMasukDariTandaTerimaPoForm extends Component
{

   public ?StockPerGudangBarangMasukDariTandaTerimaPoForm $model = null;
   public ?array $modelsDetail = null;
   public ?array $modelsDetailDetail = null;

   public function init()
   {
      parent::init();

      if ($this->model->scenario == StockPerGudangBarangMasukDariTandaTerimaPoForm::SCENARIO_STEP_2) :

         $this->modelsDetail = $this->model->tandaTerimaBarang->tandaTerimaBarangDetails;

         $this->modelsDetailDetail = [];
         foreach ($this->modelsDetail as $i => $detail) :
            $this->modelsDetailDetail[$i][] = new HistoryLokasiBarang([
               'tanda_terima_barang_detail_id' => $detail->id,
            ]);
         endforeach;

      endif;

   }

   /**
    * @throws ServerErrorHttpException
    */
   public function save(): bool
   {
      $this->modelsDetail = Tabular::createMultiple(TandaTerimaBarangDetail::class, $this->modelsDetail);
      Tabular::loadMultiple($this->modelsDetail, Yii::$app->request->post());
      $this->model->tandaTerimaBarangDetails = $this->modelsDetail;

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

         /** @var TandaTerimaBarangDetail $item */
         foreach ($this->modelsDetail as $indexDetail => $item) {
            $item->scenario = TandaTerimaBarangDetail::SCENARIO_INPUT_KE_GUDANG;
            $item->totalQuantityTerimaPerbandiganLokasi = array_sum(
               ArrayHelper::getColumn($this->modelsDetailDetail[$indexDetail], 'quantity')
            );
         }
      }

      $this->model->historyLokasiBarangs = $this->modelsDetailDetail;

      $isValid = $this->model->validate() && $isValid;
      $isValid = Tabular::validateMultiple($this->modelsDetail) && $isValid;

      if ($isValid) {
         if ($this->model->save()) return true;
      }

      return false;
   }
}