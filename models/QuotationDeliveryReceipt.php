<?php

namespace app\models;

use app\models\base\QuotationDeliveryReceipt as BaseQuotationDeliveryReceipt;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "quotation_delivery_receipt".
 */
class QuotationDeliveryReceipt extends BaseQuotationDeliveryReceipt
{

   use NomorSuratTrait;

   const SCENARIO_CREATE = 'create';
   const SCENARIO_UPDATE = 'update';

   /**
    * @var QuotationDeliveryReceiptDetail[] | null
    * */
   public ?array $modelsQuotationDeliveryReceiptDetail = null;

   /**
    * @var array| null
    */
   public ?array $deletedQuotationDeliveryReceiptDetail = null;

   public function behaviors()
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
            [
               'class' => 'mdm\autonumber\Behavior',
               'attribute' => 'nomor', // required
               'value' => '?' . '/IFTJKT/FJ/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
               'digit' => 4
            ],
         ]
      );
   }

   public function rules(): array
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
            [['modelsQuotationDeliveryReceiptDetail'], 'required', 'on' => self::SCENARIO_CREATE],
            [['modelsQuotationDeliveryReceiptDetail'], 'required', 'on' => self::SCENARIO_UPDATE],
            [['deletedQuotationDeliveryReceiptDetail'], 'safe', 'on' => self::SCENARIO_UPDATE],
         ]
      );
   }

   public function scenarios(): array
   {
      $scenarios = parent::scenarios();
      $scenarios[self::SCENARIO_CREATE] = [
         'tanggal',
         'purchase_order_number',
         'checker',
         'vehicle',
         'remarks',
         'modelsQuotationDeliveryReceiptDetail'
      ];
      $scenarios[self::SCENARIO_UPDATE] = [
         'tanggal',
         'purchase_order_number',
         'checker',
         'vehicle',
         'remarks',
         'modelsQuotationDeliveryReceiptDetail',
         'deletedQuotationDeliveryReceiptDetail'
      ];
      return $scenarios;
   }


   /**
    * @param array $modelsDetail
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function createWithDetails(array $modelsDetail): bool
   {
      $transaction = self::getDb()->beginTransaction();

      try {

         if ($flag = $this->save(false)) {
            /** @var QuotationDeliveryReceiptDetail $detail */
            foreach ($modelsDetail as $detail) :
               $detail->quotation_delivery_receipt_id = $this->id;
               if (!($flag = $detail->save(false))) {
                  break;
               }
            endforeach;
         }

         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException($e->getMessage());
      }

      return false;
   }

   /**
    * @return bool
    * @throws ServerErrorHttpException
    */
   public function updateWithDetails(): bool
   {
      $transaction = self::getDb()->beginTransaction();
      try {
         if ($flag = $this->save(false)) {

            if (!empty($this->deletedQuotationDeliveryReceiptDetail)) {
               QuotationDeliveryReceiptDetail::deleteAll(['id' => $this->deletedQuotationDeliveryReceiptDetail]);
            }

            /** @var \app\models\base\QuotationDeliveryReceiptDetail $detail */
            foreach ($this->modelsQuotationDeliveryReceiptDetail as $detail) :
               $detail->quotation_delivery_receipt_id = $this->id;
               if (!($flag = $detail->save(false))) {
                  break;
               }
            endforeach;
         }

         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         throw new ServerErrorHttpException($e->getMessage());
      }

      return false;
   }


   public function beforeSave($insert)
   {

      // Hitung quantity indent disini

      return parent::beforeSave($insert);
   }
}
