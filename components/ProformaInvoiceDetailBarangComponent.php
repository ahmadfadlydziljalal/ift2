<?php

namespace app\components;

use app\models\ProformaInvoice;
use app\models\ProformaInvoiceDetailBarang;
use app\models\ProformaInvoiceDetailBarang as ModelProformaInvoiceDetailBarang;
use app\models\Tabular;
use Throwable;
use Yii;
use yii\base\Component;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ProformaInvoiceDetailBarangComponent extends Component
{

   public ?string $scenario = null;

   public int $proformaInvoiceId;

   public ProformaInvoice $proformaInvoice;


   /** @var ProformaInvoiceDetailBarang[] */
   public array $proformaInvoiceDetailBarangs;

   /**
    * @throws NotFoundHttpException
    */
   public function init()
   {
      parent::init();
      $this->proformaInvoice = $this->findProformaInvoice($this->proformaInvoiceId);

      switch ($this->scenario):

         case ProformaInvoice::SCENARIO_CREATE_PROFORMA_INVOICE_DETAIL_BARANG;
            $this->proformaInvoice->scenario = $this->scenario;
            $this->proformaInvoiceDetailBarangs = array_map(function ($el) {
               return new ModelProformaInvoiceDetailBarang([
                  'attributes' => $el->attributes
               ]);
            }, $this->proformaInvoice->quotation->quotationBarangs);
            break;

         case ProformaInvoice::SCENARIO_UPDATE_PROFORMA_INVOICE_DETAIL_BARANG:
            $this->proformaInvoice->scenario = $this->scenario;
            $this->proformaInvoiceDetailBarangs = empty($this->proformaInvoice->proformaInvoiceDetailBarangs)
               ? [new ModelProformaInvoiceDetailBarang()]
               : $this->proformaInvoice->proformaInvoiceDetailBarangs;
            break;

         default:
            break;
      endswitch;

   }

   /**
    * Find model ProformaInvoice
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
    * Memastikan saat create, tidak ada proforma invoice detail barang di database
    * @return bool
    */
   public function checkThatProformaInvoiceHasNotExist(): bool
   {
      if (!empty(ModelProformaInvoiceDetailBarang::findAll(['proforma_invoice_id' => $this->proformaInvoiceId]))) {
         Yii::$app->session->setFlash('danger', [[
            'message' => 'Proforma Invoice ' . $this->proformaInvoice->nomor . ' sudah atau masih ada di database'
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
      $this->proformaInvoiceDetailBarangs = Tabular::createMultiple(
         ModelProformaInvoiceDetailBarang::class
      );

      Tabular::loadMultiple(
         $this->proformaInvoiceDetailBarangs,
         Yii::$app->request->post()
      );

      $this->proformaInvoice->modelsProformaInvoiceDetailsBarang = $this->proformaInvoiceDetailBarangs;

      if (Tabular::validateMultiple($this->proformaInvoiceDetailBarangs)) {
         if ($this->proformaInvoice->createModelsProformaInvoiceDetailBarang()) {
            Yii::$app->session->setFlash('success', [[
               'title' => 'Proforma invoice barang sukses disimpan',
               'message' => 'Proforma invoice barang berhasil disimpan'
            ]]);
            return true;
         }
      }

      Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
      return false;
   }

   /**
    * Update multi record di database
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function update(): bool
   {
      $oldDetailsId = ArrayHelper::map($this->proformaInvoiceDetailBarangs, 'id', 'id');
      $this->proformaInvoiceDetailBarangs = Tabular::createMultiple(
         ModelProformaInvoiceDetailBarang::class,
         $this->proformaInvoiceDetailBarangs
      );

      Tabular::loadMultiple(
         $this->proformaInvoiceDetailBarangs,
         Yii::$app->request->post()
      );
      $deletedOldDetailsId = array_diff(
         $oldDetailsId,
         array_filter(
            ArrayHelper::map(
               $this->proformaInvoiceDetailBarangs,
               'id',
               'id'
            )
         )
      );

      $this->proformaInvoice->modelsProformaInvoiceDetailsBarang = $this->proformaInvoiceDetailBarangs;
      $this->proformaInvoice->deletedProformaInvoiceDetailsBarangId = $deletedOldDetailsId;

      if (Tabular::validateMultiple($this->proformaInvoiceDetailBarangs)) {

         if ($this->proformaInvoice->updateModelsProformaInvoiceDetailBarang()) {
            Yii::$app->session->setFlash('success', [[
               'title' => 'Proforma invoice barang sukses disimpan',
               'message' => 'Proforma invoice barang berhasil disimpan'
            ]]);

            return true;
         }

      }

      Yii::$app->session->setFlash('danger', [[
         'title' => 'Gagal menyimpan proforma invoice barang'
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
      foreach ($this->proformaInvoice->proformaInvoiceDetailBarangs as $model) {
         $model->delete();
      }
      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus item proforma invoice barang ' . $this->proformaInvoice->nomor,
      ]]);
   }

}