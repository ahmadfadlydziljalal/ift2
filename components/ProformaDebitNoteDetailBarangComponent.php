<?php

namespace app\components;

use app\models\ProformaDebitNote;
use app\models\ProformaDebitNoteDetailBarang as ModelProformaDebitNoteDetailBarang;
use app\models\Tabular;
use Throwable;
use Yii;
use yii\base\Component;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ProformaDebitNoteDetailBarangComponent extends Component
{

   public ?string $scenario = null;

   public int $proformaDebitNoteId;

   public ProformaDebitNote $proformaDebitNote;


   /** @var ModelProformaDebitNoteDetailBarang */
   public array $proformaDebitNoteDetailBarangs;

   /**
    * @throws NotFoundHttpException
    */
   public function init()
   {
      parent::init();
      $this->proformaDebitNote = $this->findProformaDebiNote($this->proformaDebitNoteId);

      switch ($this->scenario):

         case ProformaDebitNote::SCENARIO_CREATE_PROFORMA_DEBIT_NOTE_DETAIL_BARANG;
            $this->proformaDebitNote->scenario = $this->scenario;
            $this->proformaDebitNoteDetailBarangs = array_map(function ($el) {
               return new ModelProformaDebitNoteDetailBarang([
                  'attributes' => $el->attributes
               ]);
            }, $this->proformaDebitNote->quotation->quotationBarangs);
            break;

         case ProformaDebitNote::SCENARIO_UPDATE_PROFORMA_DEBIT_NOTE_DETAIL_BARANG:
            $this->proformaDebitNote->scenario = $this->scenario;
            $this->proformaDebitNoteDetailBarangs = empty($this->proformaDebitNote->proformaDebitNoteDetailBarangs)
               ? [new ModelProformaDebitNoteDetailBarang()]
               : $this->proformaDebitNote->proformaDebitNoteDetailBarangs;
            break;

         default:
            break;
      endswitch;

   }

   /**
    * Find model ProformaDebitNote
    * @param int $proformaDebitNoteId
    * @return ProformaDebitNote|null
    * @throws NotFoundHttpException
    */
   private function findProformaDebiNote(int $proformaDebitNoteId): ?ProformaDebitNote
   {
      if (($model = ProformaDebitNote::findOne($proformaDebitNoteId)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

   /**
    * Memastikan saat create, tidak ada proforma invoice detail barang di database
    * @return bool
    */
   public function checkThatProformaDebitNoteHasNotExist(): bool
   {
      if (!empty(ModelProformaDebitNoteDetailBarang::findAll(['proforma_debit_note_id' => $this->proformaDebitNoteId]))) {
         Yii::$app->session->setFlash('danger', [[
            'message' => 'Proforma Debit Note ' . $this->proformaDebitNote->nomor . ' sudah atau masih ada di database'
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
      $this->proformaDebitNoteDetailBarangs = Tabular::createMultiple(
         ModelProformaDebitNoteDetailBarang::class
      );

      Tabular::loadMultiple(
         $this->proformaDebitNoteDetailBarangs,
         Yii::$app->request->post()
      );

      $this->proformaDebitNote->modelsProformaDebitNoteDetailsBarang = $this->proformaDebitNoteDetailBarangs;

      if (Tabular::validateMultiple($this->proformaDebitNoteDetailBarangs)) {
         if ($this->proformaDebitNote->createModelsProformaDebitNoteDetailBarang()) {
            Yii::$app->session->setFlash('success', [[
               'title' => 'Pesan Sukses',
               'message' => 'Proforma debit note barang berhasil disimpan'
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
      $oldDetailsId = ArrayHelper::map($this->proformaDebitNoteDetailBarangs, 'id', 'id');
      $this->proformaDebitNoteDetailBarangs = Tabular::createMultiple(
         ModelProformaDebitNoteDetailBarang::class,
         $this->proformaDebitNoteDetailBarangs
      );

      Tabular::loadMultiple(
         $this->proformaDebitNoteDetailBarangs,
         Yii::$app->request->post()
      );
      $deletedOldDetailsId = array_diff(
         $oldDetailsId,
         array_filter(
            ArrayHelper::map(
               $this->proformaDebitNoteDetailBarangs,
               'id',
               'id'
            )
         )
      );

      $this->proformaDebitNote->modelsProformaDebitNoteDetailsBarang = $this->proformaDebitNoteDetailBarangs;
      $this->proformaDebitNote->deletedProformaDebitNoteDetailsBarangId = $deletedOldDetailsId;

      if (Tabular::validateMultiple($this->proformaDebitNoteDetailBarangs)) {

         if ($this->proformaDebitNote->updateModelsProformaDebitNoteDetailBarang()) {
            Yii::$app->session->setFlash('success', [[
               'title' => 'Pesan Sukses',
               'message' => 'Proforma debit note barang berhasil disimpan'
            ]]);

            return true;
         }

      }

      Yii::$app->session->setFlash('danger', [[
         'title' => 'Gagal menyimpan proforma debit note barang'
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
      foreach ($this->proformaDebitNote->proformaDebitNoteDetailBarangs as $model) {
         $model->delete();
      }
      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus item proforma debit note barang ' . $this->proformaDebitNote->nomor,
      ]]);
   }

}