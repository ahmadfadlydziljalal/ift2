<?php

namespace app\models;

use app\models\base\QuotationFormJob as BaseQuotationFormJob;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "quotation_form_job".
 * @property string $cardOwnEquipmentLabel
 * @property string $namaMekanik
 * @property array $namaMekaniks
 */
class QuotationFormJob extends BaseQuotationFormJob
{

   const SCENARIO_CREATE_UPDATE = 'SCENARIO_CREATE_UPDATE';

   use NomorSuratTrait;

   public ?array $mekaniksId = null;

   /**
    * @inheritdoc
    * @return array
    */
   public function behaviors(): array
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
            ['mekaniksId', 'each', 'rule' => ['integer']],
            [['mekaniksId'], 'required', 'on' => [self::SCENARIO_CREATE_UPDATE]]
         ]
      );
   }

   /**
    * @inheritdoc
    * @param $insert
    * @return bool
    * @throws InvalidConfigException
    */
   public function beforeSave($insert): bool
   {
      $this->tanggal = Yii::$app->formatter->asDate($this->tanggal, "php:Y-m-d");
      return parent::beforeSave($insert);
   }

   /**
    * @inheritDoc
    * @return void
    * @throws InvalidConfigException
    */
   public function afterFind(): void
   {
      parent::afterFind();
      if (!empty($this->tanggal)) {
         $this->tanggal = Yii::$app->formatter->asDate($this->tanggal);
      }
   }

   /**
    * @inheritDoc
    * @return array
    */
   public function attributeLabels(): array
   {
      return ArrayHelper::merge(
         parent::attributeLabels(),
         [
            'id' => 'ID',
            'quotation_id' => 'Quotation',
            'nomor' => 'Nomor',
            'tanggal' => 'Tanggal',
            'person_in_charge' => 'Person In Charge',
            'issue' => 'Issue',
            'card_own_equipment_id' => 'Card Own Equipment',
            'hour_meter' => 'Hour Meter',
            'mekanik_id' => 'Mekanik',
            'mekaniksId' => 'Mekanik - Mekanik'
         ]
      );
   }

   /**
    * @return string
    */
   public function getCardOwnEquipmentLabel(): string
   {
      return !empty($this->cardOwnEquipment)
         ? $this->cardOwnEquipment->nama . ' ' . $this->cardOwnEquipment->serial_number
         : "No Equipment";
   }

   /**
    * @return string
    */
   public function getNamaMekanik(): string
   {
      return !empty($this->mekanik) ? $this->mekanik->nama : "No Mekanik";
   }

   /**
    * @return array
    */
   public function getNamaMekaniks(): array
   {
      if (!$this->quotationFormJobMekaniks) {
         return [];
      }

      $namaMekanik = [];
      foreach ($this->quotationFormJobMekaniks as $quotationFormJobMekanik) {
         $namaMekanik[] = $quotationFormJobMekanik->mekanik->nama;
      }
      return $namaMekanik;
   }

   /**
    * Menmbuat sebuah record baru dengan satu atau beberapa mekanik-mekanik
    * @return bool
    */
   public function createFormJob(): bool
   {
      $transaction = self::getDb()->beginTransaction();
      try {
         if ($flag = $this->save()) :
            foreach ($this->mekaniksId as $mekanikId) :
               if (!$flag) break;
               $flag = (new QuotationFormJobMekanik([
                  'mekanik_id' => $mekanikId,
                  'quotation_form_job_id' => $this->id
               ]))->save(false);
            endforeach;
         endif;

         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }
      } catch (Exception $e) {
         $transaction->rollBack();
      }
      return false;
   }

   /**
    * Merubah record form job, also re-insert quotation-form-job-mekaniks
    * @return bool
    * @throws Throwable
    */
   public function updateFormJob(): bool
   {

      # Find diff, antara `data yang sudah ada` dengan `data yang dikirim dari form via variable mekaniksId`
      $deletedMekaniksId = array_diff(
         ArrayHelper::getColumn($this->quotationFormJobMekaniks, 'mekanik_id'),
         array_map('intval', $this->mekaniksId)
      );

      # Transaction database
      $transaction = self::getDb()->beginTransaction();
      try {

         # Save model ini
         if ($flag = $this->save(false)) {

            # Delete jika ada penggantian nama mekanik
            if (!empty($deletedMekaniksId)) {
               foreach ($deletedMekaniksId as $mekanikId) {
                  if (!$flag) break;
                  $flag = (QuotationFormJobMekanik::findOne([
                     'quotation_form_job_id' => $this->id,
                     'mekanik_id' => $mekanikId
                  ]))->delete();
               }
            }

            # Update detail
            foreach ($this->mekaniksId as $mekanikId) {

               if (!$flag) break;

               # Find record yang exist
               $check = QuotationFormJobMekanik::findOne([
                  'quotation_form_job_id' => $this->id,
                  'mekanik_id' => (int)$mekanikId
               ]);

               # Kalau ada nama baru yang muncul, insert/save record baru
               if (!$check) {
                  $flag = (new QuotationFormJobMekanik([
                     'quotation_form_job_id' => $this->id,
                     'mekanik_id' => $mekanikId
                  ]))->save(false);
               }

               # Selebihnya abaikan
            }
         }

         if ($flag) {
            $transaction->commit();
            return true;
         } else {
            $transaction->rollBack();
         }

      } catch (Exception $e) {
         $transaction->rollBack();
      }

      return false;
   }


}