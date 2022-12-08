<?php

namespace app\components;

use app\models\ProformaInvoice;
use app\models\ProformaInvoiceDetailService;
use app\models\ProformaInvoiceDetailService as ModelProformaInvoiceDetailService;
use app\models\Tabular;
use Yii;
use yii\base\Component;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ProformaInvoiceDetailServiceComponent extends Component
{
   public ?string $scenario = null;

   public int $proformaInvoiceId;

   public ProformaInvoice $proformaInvoice;

   /** @var ProformaInvoiceDetailService[] */
   public array $proformaInvoiceDetailServices;

   /**
    * @throws NotFoundHttpException
    */
   public function init()
   {
      parent::init();
      $this->proformaInvoice = $this->findProformaInvoice($this->proformaInvoiceId);

      switch ($this->scenario):

         case ProformaInvoice::SCENARIO_CREATE_PROFORMA_INVOICE_DETAIL_SERVICE;
            $this->proformaInvoice->scenario = $this->scenario;
            $this->proformaInvoiceDetailServices = array_map(function ($el) {
               return new ModelProformaInvoiceDetailService([
                  'attributes' => $el->attributes
               ]);
            }, $this->proformaInvoice->quotation->quotationServices);
            break;

         case ProformaInvoice::SCENARIO_UPDATE_PROFORMA_INVOICE_DETAIL_SERVICE:
            $this->proformaInvoice->scenario = $this->scenario;
            $this->proformaInvoiceDetailServices = empty($this->proformaInvoice->proformaInvoiceDetailServices)
               ? [new ModelProformaInvoiceDetailService()]
               : $this->proformaInvoice->proformaInvoiceDetailServices;
            break;

         default:
            break;
      endswitch;

   }

   /**
    * @param int $proformaInvoiceId
    * @return ProformaInvoice|null
    * @throws NotFoundHttpException
    */
   private function findProformaInvoice(int $proformaInvoiceId): ?ProformaInvoice
   {
      if (($model = ProformaInvoice::findOne($proformaInvoiceId)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

   /**
    * Memastikan saat create, tidak ada proforma invoice detail service di database
    * @return bool
    */
   public function checkThatProformaInvoiceHasNotExist(): bool
   {
      if (!empty(ModelProformaInvoiceDetailService::findAll(['proforma_invoice_id' => $this->proformaInvoiceId]))) {
         Yii::$app->session->setFlash('danger', [[
            'message' => 'Proforma Invoice ' . $this->proformaInvoice->nomor . ' service sudah atau masih ada di database'
         ]]);
         return true;
      }
      return false;
   }

   /**
    * Insert multi record ke database
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function create(): bool
   {
      $this->proformaInvoiceDetailServices = Tabular::createMultiple(
         ModelProformaInvoiceDetailService::class
      );

      Tabular::loadMultiple(
         $this->proformaInvoiceDetailServices,
         Yii::$app->request->post()
      );

      $this->proformaInvoice->modelsProformaInvoiceDetailsService = $this->proformaInvoiceDetailServices;

      if (Tabular::validateMultiple($this->proformaInvoiceDetailServices)) {
         if ($this->proformaInvoice->createModelsProformaInvoiceDetailService()) {
            Yii::$app->session->setFlash('success', [[
               'title' => 'Proforma invoice service sukses disimpan',
               'message' => 'Proforma invoice service berhasil disimpan'
            ]]);
            return true;
         }
      }

      Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
      return false;
   }


   /**
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function update(): bool
   {


      $oldDetailsId = ArrayHelper::map(
         $this->proformaInvoiceDetailServices,
         'id',
         'id'
      );
      $this->proformaInvoiceDetailServices = Tabular::createMultiple(
         ModelProformaInvoiceDetailService::class,
         $this->proformaInvoiceDetailServices
      );

      Tabular::loadMultiple(
         $this->proformaInvoiceDetailServices,
         Yii::$app->request->post()
      );

      $deletedOldDetailsId = array_diff(
         $oldDetailsId,
         array_filter(
            ArrayHelper::map(
               $this->proformaInvoiceDetailServices,
               'id',
               'id'
            )
         )
      );

      $this->proformaInvoice->modelsProformaInvoiceDetailsService = $this->proformaInvoiceDetailServices;
      $this->proformaInvoice->deletedProformaInvoiceDetailsServiceId = $deletedOldDetailsId;

      if (Tabular::validateMultiple($this->proformaInvoiceDetailServices)) {


         if ($this->proformaInvoice->updateModelsProformaInvoiceDetailService()) {
            Yii::$app->session->setFlash('success', [[
               'title' => 'Proforma invoice service sukses disimpan',
               'message' => 'Proforma invoice service berhasil disimpan'
            ]]);

            return true;
         }

      }

      Yii::$app->session->setFlash('danger', [[
         'title' => 'Gagal menyimpan proforma invoice service'
      ]]);
      return false;
   }

   /**
    * @return void
    * @throws Throwable
    * @throws StaleObjectException
    */
   public function delete(): void
   {
      foreach ($this->proformaInvoice->proformaInvoiceDetailServices as $model) {
         $model->delete();
      }
      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus item proforma invoice service ' . $this->proformaInvoice->nomor,
      ]]);
   }

}