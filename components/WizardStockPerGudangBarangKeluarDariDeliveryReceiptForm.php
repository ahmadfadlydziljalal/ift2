<?php

namespace app\components;

use app\components\helpers\ArrayHelper;
use app\models\form\StockPerGudangBarangKeluarDariDeliveryReceiptForm;
use app\models\HistoryLokasiBarang;
use app\models\QuotationDeliveryReceiptDetail;
use app\models\Status;
use app\models\Tabular;
use Yii;
use yii\base\Component;
use yii\web\ServerErrorHttpException;

class WizardStockPerGudangBarangKeluarDariDeliveryReceiptForm extends Component
{

   public ?StockPerGudangBarangKeluarDariDeliveryReceiptForm $model = null;
   public ?array $modelsDetail = null;
   public ?array $modelsDetailDetail = null;

   public function init()
   {
      parent::init();

      if ($this->model->scenario == StockPerGudangBarangKeluarDariDeliveryReceiptForm::SCENARIO_STEP_2):

         $this->modelsDetail = $this->model->quotationDeliveryReceipt->quotationDeliveryReceiptDetails;

         $this->modelsDetailDetail = [];
         foreach ($this->modelsDetail as $i => $detail) {
            $this->modelsDetailDetail[$i][] = new HistoryLokasiBarang([
               'quotation_delivery_receipt_detail_id' => $detail->id,
            ]);
         }
      endif;

   }

   /**
    * @throws ServerErrorHttpException
    */
   public function save(): bool
   {

      $this->modelsDetail = Tabular::createMultiple(
         QuotationDeliveryReceiptDetail::class,
         $this->modelsDetail
      );

      Tabular::loadMultiple($this->modelsDetail, Yii::$app->request->post());
      $this->model->quotationDeliveryReceiptDetails = $this->modelsDetail;

      $isValid = true;
      if (isset($_POST['HistoryLokasiBarang'][0][0])) {

         foreach ($_POST['HistoryLokasiBarang'] as $i => $historyLokasiBarangs) {
            foreach ($historyLokasiBarangs as $j => $historyLokasiBarang) {
               $data['HistoryLokasiBarang'] = $historyLokasiBarang;

               $modelHistoryLokasiBarang = new HistoryLokasiBarang();
               $modelHistoryLokasiBarang->load($data);

               $modelHistoryLokasiBarang->tipe_pergerakan_id = Status::findOne([
                  'section' => Status::SECTION_SET_LOKASI_BARANG,
                  'key' => 'out'
               ])->id;

               $modelHistoryLokasiBarang->step = 0;

               $this->modelsDetailDetail[$i][$j] = $modelHistoryLokasiBarang;
               $isValid = $modelHistoryLokasiBarang->validate() && $isValid;
            }
         }

         /** @var QuotationDeliveryReceiptDetail $item */
         foreach ($this->modelsDetail as $indexDetail => $item) :
            $item->scenario = QuotationDeliveryReceiptDetail::SCENARIO_INPUT_KE_GUDANG;
            $item->totalQuantityTerimaPerbandiganLokasi = array_sum(
               ArrayHelper::getColumn($this->modelsDetailDetail[$indexDetail], 'quantity')
            );
         endforeach;
      }

      $isValid = $this->model->validate() && $isValid;
      $isValid = Tabular::validateMultiple($this->modelsDetail) && $isValid;

      if ($isValid) {
         $this->model->historyLokasiBarangs = $this->modelsDetailDetail;
         if ($this->model->save()) return true;
      }
      return false;
   }

}