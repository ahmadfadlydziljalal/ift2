<?php

namespace app\components;

use app\models\Quotation;
use app\models\QuotationBarang;
use app\models\Tabular;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class BarangQuotation extends Component implements CreateModelDetails, UpdateModelDetails, DeleteModelDetails
{

   public ?int $quotationId = null;
   public ?string $scenario = null;

   public ?Quotation $quotation = null;
   public ?array $quotationBarangs = null;

   /**
    * @throws NotFoundHttpException
    * @throws InvalidConfigException
    */
   public function init()
   {
      parent::init();

      $this->quotation = $this->findModel($this->quotationId);
      switch ($this->scenario) :

         case Quotation::SCENARIO_CREATE_BARANG_QUOTATION:
            $this->quotation->scenario = $this->scenario;
            $this->quotationBarangs = [new QuotationBarang(['quotation_id' => $this->quotationId])];
            break;

         case Quotation::SCENARIO_UPDATE_BARANG_QUOTATION:
            $this->quotation->scenario = $this->scenario;
            $this->quotationBarangs = empty($this->quotation->quotationBarangs)
               ? [new QuotationBarang(['quotation_id' => $this->quotationId])]
               : $this->quotation->quotationBarangs;
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
    */
   public function create(): bool
   {

      $this->quotationBarangs = Tabular::createMultiple(QuotationBarang::class);
      Tabular::loadMultiple($this->quotationBarangs, Yii::$app->request->post());

      $this->quotation->modelsQuotationBarang = $this->quotationBarangs;

      if ($this->quotation->validate() && Tabular::validateMultiple($this->quotationBarangs)) {
         if ($this->quotation->createModelsQuotationBarang()) {
            Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
            return true;
         }
      }

      Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
      return false;
   }

   /**
    * @return bool
    */
   public function update(): bool
   {
      $oldDetailsId = ArrayHelper::map($this->quotationBarangs, 'id', 'id');
      $this->quotationBarangs = Tabular::createMultiple(QuotationBarang::class, $this->quotationBarangs);

      Tabular::loadMultiple($this->quotationBarangs, Yii::$app->request->post());
      $deletedOldDetailsId = array_diff($oldDetailsId, array_filter(ArrayHelper::map($this->quotationBarangs, 'id', 'id')));

      $this->quotation->modelsQuotationBarang = $this->quotationBarangs;
      $this->quotation->deletedQuotationBarangsId = $deletedOldDetailsId;

      if ($this->quotation->validate() && Tabular::validateMultiple($this->quotationBarangs)) {

         if ($this->quotation->updateModelsQuotationBarang()) {
            Yii::$app->session->setFlash('success', 'Barang Quotation: Data sesuai dengan validasi yang ditetapkan');
            return true;
         }

      }
      Yii::$app->session->setFlash('danger', 'Barang Quotation: Data tidak sesuai dengan validasi yang ditetapkan');
      return false;
   }

   /**
    * @return void
    */
   public function delete(): void
   {
      $models = QuotationBarang::findAll(['quotation_id' => $this->quotationId]);
      array_walk($models, function ($item) {
         $item->delete();
      });
      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus quotation barang ' . Quotation::findOne($this->quotationId)->nomor,
      ]]);
   }

}