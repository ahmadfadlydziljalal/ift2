<?php

namespace app\components;

use app\components\helpers\ArrayHelper;
use app\models\Quotation;
use app\models\QuotationBarang;
use app\models\QuotationDeliveryReceipt;
use app\models\QuotationDeliveryReceiptDetail;
use app\models\Tabular;
use Throwable;
use Yii;
use yii\base\Component;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class DeliveryReceiptQuotation extends Component implements CreateModelDetails, UpdateModelDetails, DeleteModelDetails
{

   public ?int $quotationId = null;
   public ?int $quotationDeliveryReceiptId = null;
   public ?string $scenario = null;

   public ?Quotation $quotation = null;
   public ?QuotationDeliveryReceipt $quotationDeliveryReceipt = null;

   /**
    * @var QuotationBarang[]
    * */
   public ?array $quotationBarangs = null;

   /**
    * @var QuotationDeliveryReceiptDetail[]
    * */
   public ?array $quotationDeliveryReceiptDetails = null;

   /**
    * @return void
    * @throws NotFoundHttpException
    */
   public function init(): void
   {
      parent::init();


      switch ($this->scenario) :

         case QuotationDeliveryReceipt::SCENARIO_CREATE :

            $this->scenarioCreate();
            break;

         case QuotationDeliveryReceipt::SCENARIO_UPDATE:

            $this->scenarioUpdate();
            break;

         default:
            break;
      endswitch;
   }

   /**
    * @return void
    * @throws NotFoundHttpException
    */
   private function scenarioCreate(): void
   {

      $this->quotation = $this->findModel($this->quotationId);
      $this->quotationDeliveryReceipt = new QuotationDeliveryReceipt([
         'quotation_id' => $this->quotation->id,
         'scenario' => $this->scenario
      ]);

      foreach ($this->quotationBarangs as $k => $quotationBarang) {
         $this->quotationDeliveryReceiptDetails[$k] = new QuotationDeliveryReceiptDetail([
            'quotation_barang_id' => $quotationBarang->id
         ]);
      }
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
    * @throws NotFoundHttpException
    */
   private function scenarioUpdate()
   {
      $this->quotationDeliveryReceipt = QuotationDeliveryReceipt::findOne($this->quotationDeliveryReceiptId);
      $this->quotationDeliveryReceipt->scenario = $this->scenario;

      $this->quotation = $this->findModel($this->quotationDeliveryReceipt->quotation_id);

      $this->quotationDeliveryReceiptDetails = empty($this->quotationDeliveryReceipt->quotationDeliveryReceiptDetails)
         ? [new QuotationDeliveryReceiptDetail()]
         : $this->quotationDeliveryReceipt->quotationDeliveryReceiptDetails;
   }

   /**
    * @throws ServerErrorHttpException
    */
   public function create(): bool
   {
      $this->quotationDeliveryReceiptDetails = Tabular::createMultiple(QuotationDeliveryReceiptDetail::class);
      Tabular::loadMultiple($this->quotationDeliveryReceiptDetails, Yii::$app->request->post());

      $this->quotationDeliveryReceipt->modelsQuotationDeliveryReceiptDetail = $this->quotationDeliveryReceiptDetails;

      if ($this->quotationDeliveryReceipt->validate() && Tabular::validateMultiple($this->quotationDeliveryReceiptDetails)) {

         if ($this->quotationDeliveryReceipt->createWithDetails($this->quotationDeliveryReceiptDetails)) {
            Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
            return true;
         }

         Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
      }

      return false;
   }

   /**
    * @throws ServerErrorHttpException
    */
   public function update(): bool
   {

      $oldId = ArrayHelper::map($this->quotationDeliveryReceiptDetails, 'id', 'id');
      $this->quotationDeliveryReceiptDetails = Tabular::createMultiple(QuotationDeliveryReceiptDetail::class, $this->quotationDeliveryReceiptDetails);

      Tabular::loadMultiple($this->quotationDeliveryReceiptDetails, Yii::$app->request->post());
      $deletedId = array_diff($oldId, array_filter(ArrayHelper::map($this->quotationDeliveryReceiptDetails, 'id', 'id')));

      $this->quotationDeliveryReceipt->modelsQuotationDeliveryReceiptDetail = $this->quotationDeliveryReceiptDetails;
      $this->quotationDeliveryReceipt->deletedQuotationDeliveryReceiptDetail = $deletedId;

      if ($this->quotationDeliveryReceipt->validate() && Tabular::validateMultiple($this->quotationDeliveryReceiptDetails)) {

         if ($this->quotationDeliveryReceipt->updateWithDetails()) {
            Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
            return true;
         }
      }

      Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
      return false;
   }

   public function deleteAll()
   {
      $items = QuotationDeliveryReceipt::findAll(['quotation_id' => $this->quotationId]);
      array_walk($items, function ($item) {
         $item->delete();
      });
      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus semua delivery receipt ' . Quotation::findOne($this->quotationId)->nomor,
      ]]);
   }

   /**
    * @throws StaleObjectException
    * @throws Throwable
    */
   public function delete(): void
   {
      $this->quotationDeliveryReceipt = QuotationDeliveryReceipt::findOne($this->quotationDeliveryReceiptId);
      $this->quotationDeliveryReceipt->delete();
      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus delivery receipt ' . $this->quotationDeliveryReceipt->nomor,
      ]]);
   }
}