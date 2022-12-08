<?php

namespace app\components;

use app\models\ProformaDebitNote;
use app\models\ProformaDebitNoteDetailService as ModelProformaDebitNoteDetailService;
use app\models\Tabular;
use Throwable;
use Yii;
use yii\base\Component;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ProformaDebitNoteDetailServiceComponent extends Component
{
   public ?string $scenario = null;

   public int $proformaDebitNoteId;

   public ProformaDebitNote $proformaDebitNote;

   /** @var ModelProformaDebitNoteDetailService[] */
   public array $proformaDebitNoteDetailServices;

   /**
    * @throws NotFoundHttpException
    */
   public function init()
   {
      parent::init();
      $this->proformaDebitNote = $this->findProformaDebitNote($this->proformaDebitNoteId);

      switch ($this->scenario):

         case ProformaDebitNote::SCENARIO_CREATE_PROFORMA_DEBIT_NOTE_DETAIL_SERVICE;
            $this->proformaDebitNote->scenario = $this->scenario;
            $this->proformaDebitNoteDetailServices = array_map(function ($el) {
               return new ModelProformaDebitNoteDetailService([
                  'attributes' => $el->attributes
               ]);
            }, $this->proformaDebitNote->quotation->quotationServices);
            break;

         case ProformaDebitNote::SCENARIO_UPDATE_PROFORMA_DEBIT_NOTE_DETAIL_SERVICE;
            $this->proformaDebitNote->scenario = $this->scenario;
            $this->proformaDebitNoteDetailServices = empty($this->proformaDebitNote->proformaDebitNoteDetailServices)
               ? [new ModelProformaDebitNoteDetailService()]
               : $this->proformaDebitNote->proformaDebitNoteDetailServices;
            break;

         default:
            break;
      endswitch;

   }

   /**
    * @param int $proformaDebitNoteId
    * @return ProformaDebitNote|null
    * @throws NotFoundHttpException
    */
   private function findProformaDebitNote(int $proformaDebitNoteId): ?ProformaDebitNote
   {
      if (($model = ProformaDebitNote::findOne($proformaDebitNoteId)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

   /**
    * Memastikan saat create, tidak ada proforma debit note detail service di database
    * @return bool
    */
   public function checkThatProformaDebitNoteHasNotExist(): bool
   {
      if (!empty(ModelProformaDebitNoteDetailService::findAll(['proforma_debit_note_id' => $this->proformaDebitNoteId]))) {
         Yii::$app->session->setFlash('danger', [[
            'message' => 'Proforma Debit Note ' . $this->proformaDebitNote->nomor . ' service sudah atau masih ada di database'
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
      $this->proformaDebitNoteDetailServices = Tabular::createMultiple(
         ModelProformaDebitNoteDetailService::class
      );

      Tabular::loadMultiple(
         $this->proformaDebitNoteDetailServices,
         Yii::$app->request->post()
      );

      $this->proformaDebitNote->modelsProformaDebitNoteDetailsService = $this->proformaDebitNoteDetailServices;

      if (Tabular::validateMultiple($this->proformaDebitNoteDetailServices)) {
         if ($this->proformaDebitNote->createModelsProformaDebitNoteDetailService()) {
            Yii::$app->session->setFlash('success', [[
               'title' => 'Proforma sukses',
               'message' => 'Proforma debit note service berhasil disimpan'
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
         $this->proformaDebitNoteDetailServices,
         'id',
         'id'
      );
      $this->proformaDebitNoteDetailServices = Tabular::createMultiple(
         ModelProformaDebitNoteDetailService::class,
         $this->proformaDebitNoteDetailServices
      );

      Tabular::loadMultiple(
         $this->proformaDebitNoteDetailServices,
         Yii::$app->request->post()
      );

      $deletedOldDetailsId = array_diff(
         $oldDetailsId,
         array_filter(
            ArrayHelper::map(
               $this->proformaDebitNoteDetailServices,
               'id',
               'id'
            )
         )
      );

      $this->proformaDebitNote->modelsProformaDebitNoteDetailsService = $this->proformaDebitNoteDetailServices;
      $this->proformaDebitNote->deletedProformaDebitNoteDetailsServiceId = $deletedOldDetailsId;

      if (Tabular::validateMultiple($this->proformaDebitNoteDetailServices)) {


         if ($this->proformaDebitNote->updateModelsProformaDebitNoteDetailService()) {
            Yii::$app->session->setFlash('success', [[
               'title' => 'Pesan Sukses',
               'message' => 'Proforma debit note service berhasil disimpan'
            ]]);

            return true;
         }

      }

      Yii::$app->session->setFlash('danger', [[
         'title' => 'Gagal menyimpan proforma debit note service'
      ]]);
      return false;
   }


   /**
    * @return void
    * @throws StaleObjectException
    * @throws Throwable
    * @throws Throwable
    */
   public function delete(): void
   {
      foreach ($this->proformaDebitNote->proformaDebitNoteDetailServices as $model) {
         $model->delete();
      }
      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus item proforma debit note service ' . $this->proformaDebitNote->nomor,
      ]]);
   }

}