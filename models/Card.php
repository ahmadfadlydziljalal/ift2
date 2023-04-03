<?php

namespace app\models;

use app\models\base\Card as BaseCard;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\ServerErrorHttpException;

/**
 * This is the model class for table "card".
 * @property CardType[] $cardTypes
 */
class Card extends BaseCard
{

   const SCENARIO_CREATE_AND_UPDATE = 'create-and-update';
   const GET_ALL = 'all';
   const GET_ONLY_TOKO_SAYA = 'only-toko-saya';
   const GET_APART_FROM_TOKO_SAYA = 'selain-toko-saya';
   const GET_ONLY_VENDOR = 'only-vendor';
   const GET_ONLY_PEJABAT_KANTOR = 'only-pejabat-kantor';
   const GET_ONLY_MEKANIK = 'only-mekanik';
   const GET_ONLY_WAREHOUSE = 'warehouse';
   const GET_ONLY_CUSTOMER = 'only-customer';

   public ?array $cardBelongsTypesForm = [];
   public ?string $cardTypeName = null;

   public function behaviors()
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [
            # custom behaviors
         ]
      );
   }

   public function rules()
   {
      return ArrayHelper::merge(
         parent::rules(),
         [
            # custom validation rules
            ['cardTypeName', 'safe'],
            ['cardBelongsTypesForm', 'each', 'rule' => ['integer']],
            [['cardBelongsTypesForm'], 'required', 'on' => self::SCENARIO_CREATE_AND_UPDATE],
         ]
      );
   }

   public function getSingkatanNama(): string
   {
      return StringHelper::truncate($this->nama, 18);
   }


   /**
    * @return ActiveQuery
    */
   public function getCardTypes()
   {
      return $this->hasMany(CardType::class, ['id' => 'card_type_id'])
         ->via('cardBelongsTypes');
   }

   public function attributeLabels()
   {
      return ArrayHelper::merge(
         parent::attributeLabels(), [
            'mata_uang_id' => 'Mata Uang',
         ]
      );
   }

   /**
    * @throws ServerErrorHttpException
    */
   public function createWithCardBelongsType(): bool
   {
      $transaction = self::getDb()->beginTransaction();

      try {

         if ($flag = $this->save(false)) :

            foreach ($this->cardBelongsTypesForm as $cardType) :
               if (!$flag) break;

               $flag = (new CardBelongsType([
                  'card_id' => $this->id,
                  'card_type_id' => $cardType
               ]))->save(false);

            endforeach;

         endif;

         if ($flag) {

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Card: ' . $this->nama . ' berhasil ditambahkan.');

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
    * @param $deletedCardBelongsTypeID
    * @return bool
    */
   public function updateWithCardBelongsType($deletedCardBelongsTypeID): bool
   {
      $transaction = self::getDb()->beginTransaction();

      try {
         if ($flag = $this->save(false)) {

            if (!empty($deletedCardBelongsTypeID)) {
               CardBelongsType::deleteAll([
                  'AND', 'card_id = :card_id',
                  ['IN', 'card_type_id', $deletedCardBelongsTypeID]
               ], [
                  ':card_id' => $this->id
               ]);
            }

            foreach ($this->cardBelongsTypesForm as $cardType) {

               $exist = CardBelongsType::find()
                  ->where([
                     'card_id' => $this->id,
                     'card_type_id' => $cardType
                  ])
                  ->exists();

               if (!$exist) {

                  $cbt = new CardBelongsType([
                     'card_id' => $this->id,
                     'card_type_id' => $cardType
                  ]);

                  $flag = $cbt->save(false) && $flag;
               }

               if (!$flag) {
                  break;
               }
            }
         }

         if ($flag) {
            $transaction->commit();
            Yii::$app->session->setFlash('info',
               'Card: ' . Html::a($this->nama, ['card/view', 'id' => $this->id, [
                  'class' => 'btn btn-link'
               ]]) . ' berhasil dirubah.');

            return true;
         } else {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', "Rollback");
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         Yii::$app->session->setFlash('danger', $e->getMessage());
      }

      return false;
   }
}