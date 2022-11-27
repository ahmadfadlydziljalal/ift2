<?php

namespace app\components;

use app\components\helpers\ArrayHelper;
use app\models\Quotation;
use app\models\QuotationTermAndCondition;
use app\models\Tabular;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\web\NotFoundHttpException;

class TermConditionQuotation extends Component implements CreateModelDetails, UpdateModelDetails, DeleteModelDetails
{

   public ?int $quotationId = null;
   public ?string $scenario = null;

   public ?Quotation $quotation = null;
   public ?array $quotationTermAndConditions = null;

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

         case Quotation::SCENARIO_CREATE_TERM_AND_CONDITION:

            $this->quotation->scenario = $this->scenario;

            if (Yii::$app->request->isGet) {
               $template = Yii::$app->settings->get('quotation.term_and_condition_template');

               if ($template) {
                  foreach ($template as $item) {
                     $this->quotationTermAndConditions[] = new QuotationTermAndCondition([
                        'quotation_id' => $this->quotationId,
                        'term_and_condition' => $item
                     ]);
                  }
               } else {
                  $this->quotationTermAndConditions[] = new QuotationTermAndCondition();
               }
            }
            break;

         case Quotation::SCENARIO_UPDATE_TERM_AND_CONDITION:

            $this->quotation->scenario = $this->scenario;
            $this->quotationTermAndConditions = !empty($this->quotation->quotationTermAndConditions)
               ? $this->quotation->quotationTermAndConditions :
               [new QuotationTermAndCondition([
                  'quotation_id' => $this->quotationId
               ])];
            break;

         default:
            break;
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
    * @throws Exception
    */
   public function create(): bool
   {
      $this->quotationTermAndConditions = Tabular::createMultiple(QuotationTermAndCondition::class);
      Tabular::loadMultiple($this->quotationTermAndConditions, Yii::$app->request->post());

      $this->quotation->modelsQuotationTermAndCondition = $this->quotationTermAndConditions;

      if ($this->quotation->validate() && Tabular::validateMultiple($this->quotationTermAndConditions)) {
         if ($this->quotation->createModelsTermAndCondition()) {
            Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
            return true;
         }
      }

      Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
      return false;
   }

   /**
    * @throws Exception
    */
   public function update(): bool
   {
      $oldId = ArrayHelper::map($this->quotationTermAndConditions, 'id', 'id');
      $this->quotationTermAndConditions = Tabular::createMultiple(QuotationTermAndCondition::class, $this->quotationTermAndConditions);

      Tabular::loadMultiple($this->quotationTermAndConditions, Yii::$app->request->post());
      $deletedId = array_diff($oldId, array_filter(ArrayHelper::map($this->quotationTermAndConditions, 'id', 'id')));

      $this->quotation->modelsQuotationTermAndCondition = $this->quotationTermAndConditions;
      $this->quotation->deletedQuotationTermAndCondition = $deletedId;

      if ($this->quotation->validate() && Tabular::validateMultiple($this->quotationTermAndConditions)) {

         if ($this->quotation->updateModelsTermAndCondition()) {
            Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
            return true;
         }
      }
      Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
      return false;
   }

   /**
    * @return void
    */
   public function delete(): void
   {
      $models = QuotationTermAndCondition::findAll([
         'quotation_id' => $this->quotationId
      ]);
      array_walk($models, function ($item) {
         $item->delete();
      });
      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus term and condition ' . Quotation::findOne($this->quotationId)->nomor,
      ]]);
   }
}