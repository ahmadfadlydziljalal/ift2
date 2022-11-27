<?php

namespace app\components;

use app\models\Quotation;
use app\models\QuotationService;
use app\models\Tabular;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class ServiceQuotation extends Component implements DeleteModelDetails, UpdateModelDetails, CreateModelDetails
{

   public ?int $quotationId = null;
   public ?string $scenario = null;

   public ?Quotation $quotation = null;

   /**
    * @var QuotationService[] | null
    * */
   public ?array $quotationServices = null;


   /**
    * @return void
    * @throws InvalidConfigException
    * @throws NotFoundHttpException
    */
   public function init(): void
   {
      parent::init();

      $this->quotation = $this->findModel($this->quotationId);
      switch ($this->scenario) :

         case Quotation::SCENARIO_CREATE_SERVICE_QUOTATION:
            $this->quotation->scenario = $this->scenario;
            $this->quotationServices = [new QuotationService(['quotation_id' => $this->quotationId])];
            break;

         case Quotation::SCENARIO_UPDATE_SERVICE_QUOTATION:
            $this->quotation->scenario = $this->scenario;
            $this->quotationServices = empty($this->quotation->quotationServices)
               ? [new QuotationService(['quotation_id' => $this->quotationId])]
               : $this->quotation->quotationServices;
            break;

         default:
            throw new InvalidConfigException('Scenario kosong, tolong provide scenario model yang didukung');
      endswitch;
   }

   /**
    * @throws NotFoundHttpException
    */
   protected function findModel(int $id): Quotation
   {
      if (($model = Quotation::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

   /**
    * @return bool
    * @throws Exception
    */
   public function create(): bool
   {
      $this->quotationServices = Tabular::createMultiple(QuotationService::class);
      Tabular::loadMultiple($this->quotationServices, Yii::$app->request->post());

      $this->quotation->modelsQuotationService = $this->quotationServices;
      if ($this->quotation->validate() && Tabular::validateMultiple($this->quotationServices)) {
         if ($this->quotation->createModelsQuotationService()) {
            Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
            return true;
         }
      }

      Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
      return false;
   }

   /**
    * @return bool
    * @throws Exception
    */
   public function update(): bool
   {
      $oldDetailsId = ArrayHelper::map($this->quotationServices, 'id', 'id');
      $this->quotationServices = Tabular::createMultiple(QuotationService::class, $this->quotationServices);

      Tabular::loadMultiple($this->quotationServices, Yii::$app->request->post());
      $deletedOldDetailsId = array_diff($oldDetailsId, array_filter(ArrayHelper::map($this->quotationServices, 'id', 'id')));

      $this->quotation->modelsQuotationService = $this->quotationServices;
      $this->quotation->deletedQuotationServicesId = $deletedOldDetailsId;

      if ($this->quotation->validate() && Tabular::validateMultiple($this->quotationServices)) {

         if ($this->quotation->updateModelsQuotationService()) {
            Yii::$app->session->setFlash('success', 'Service Quotation: Data sesuai dengan validasi yang ditetapkan');
            return true;
         }

      }
      Yii::$app->session->setFlash('danger', 'Service Quotation: Data tidak sesuai dengan validasi yang ditetapkan');
      return false;
   }

   /**
    * @return void
    */
   public function delete(): void
   {
      $models = QuotationService::findAll(['quotation_id' => $this->quotationId]);
      array_walk($models, function ($item) {
         $item->delete();
      });

      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus quotation service ' . Quotation::findOne($this->quotationId)->nomor,
      ]]);

   }
}