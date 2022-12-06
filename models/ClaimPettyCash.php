<?php

namespace app\models;

use app\models\base\ClaimPettyCash as BaseClaimPettyCash;
use JetBrains\PhpStorm\ArrayShape;
use yii\db\ActiveQuery;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "claim_petty_cash".
 * @property $claimPettyCashNotaDetails ClaimPettyCashNotaDetail[]
 * @property $historyLokasiBarangs HistoryLokasiBarang[]
 */
class ClaimPettyCash extends BaseClaimPettyCash
{

   public ?string $text = null;

   public function behaviors()
   {
      return ArrayHelper::merge(
         parent::behaviors(),
         [

            [
               'class' => 'mdm\autonumber\Behavior',
               'attribute' => 'nomor', // required
               'value' => '?' . '/IFTJKT/CPC/' . date('m/Y'), // format auto number. '?' will be replaced with generated number
               'digit' => 4
            ],
         ]
      );
   }

   public function rules()
   {
      return ArrayHelper::merge(
         parent::rules(),
         [

         ]
      );
   }

   public function attributeLabels()
   {
      return ArrayHelper::merge(
         parent::attributeLabels(), [
            'id' => 'ID',
            'nomor' => 'Nomor',
            'vendor_id' => 'Vendor',
            'tanggal' => 'Tanggal',
            'remarks' => 'Remarks',
            'approved_by_id' => 'Approved By',
            'acknowledge_by_id' => 'Acknowledge By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
         ]
      );
   }

   /**
    * @return ActiveQuery
    */
   public function getClaimPettyCashNotaDetails(): ActiveQuery
   {
      return $this->hasMany(ClaimPettyCashNotaDetail::class, ['claim_petty_cash_nota_id' => 'id'])
         ->via('claimPettyCashNotas');
   }

   /**
    * @return ActiveQuery
    */
   public function getHistoryLokasiBarangs(): ActiveQuery
   {
      return $this->hasMany(HistoryLokasiBarang::class, ['claim_petty_cash_nota_detail_id' => 'id'])
         ->via('claimPettyCashNotaDetails');
   }

   /**
    * @return float
    */
   public function getTotalClaim(): float
   {
      $parent = $this->hasMany(ClaimPettyCashNotaDetail::class, ['claim_petty_cash_nota_id' => 'id'])
         ->via('claimPettyCashNotas');
      return round($parent->sum('quantity * harga'), 2);
   }

   /**
    * @return string
    */
   public function getNomorDisplay(): string
   {
      $nomor = explode('/', $this->nomor);
      return $nomor[0] . '-' . ($nomor[count($nomor) - 2]) . '-' . end($nomor);
   }

   #[ArrayShape(['code' => "int", 'message' => "string"])]
   public function saveWithDetails($modelsDetail, $modelsDetailDetail): array
   {
      $transaction = ClaimPettyCash::getDb()->beginTransaction();

      try {

         if ($flag = $this->save(false)) {
            foreach ($modelsDetail as $i => $detail) :

               if ($flag === false) {
                  break;
               }

               $detail->claim_petty_cash_id = $this->id;
               if (!($flag = $detail->save(false))) {
                  break;
               }

               if (isset($modelsDetailDetail[$i]) && is_array($modelsDetailDetail[$i])) {
                  foreach ($modelsDetailDetail[$i] as $modelDetailDetail) {
                     $modelDetailDetail->claim_petty_cash_nota_id = $detail->id;
                     if (!($flag = $modelDetailDetail->save(false))) {
                        break;
                     }
                  }
               }

            endforeach;
         }

         if ($flag) {
            $transaction->commit();
            $status = [
               'code' => 1,
               'message' => 'Commit'
            ];
         } else {
            $transaction->rollBack();
            $status = [
               'code' => 0,
               'message' => 'Roll Back'
            ];
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         $status = [
            'code' => 0,
            'message' => 'Roll Back ' . $e->getMessage(),
         ];
      }

      return $status;
   }

   #[ArrayShape(['code' => "int", 'message' => "string"])]
   public function updateWithDetails($modelsDetail, $modelsDetailDetail, $deletedDetailsID, $deletedDetailDetailsIDs): array
   {
      $transaction = ClaimPettyCash::getDb()->beginTransaction();

      try {

         if ($flag = $this->save(false)) {

            if (!empty($deletedDetailDetailsIDs)) {
               ClaimPettyCashNotaDetail::deleteAll(['id' => $deletedDetailDetailsIDs]);
            }

            if (!empty($deletedDetailsID)) {
               ClaimPettyCashNota::deleteAll(['id' => $deletedDetailsID]);
            }

            foreach ($modelsDetail as $i => $detail) :

               if ($flag === false) {
                  break;
               }

               $detail->claim_petty_cash_id = $this->id;
               if (!($flag = $detail->save(false))) {
                  break;
               }

               if (isset($modelsDetailDetail[$i]) && is_array($modelsDetailDetail[$i])) {
                  foreach ($modelsDetailDetail[$i] as $modelDetailDetail) {
                     $modelDetailDetail->claim_petty_cash_nota_id = $detail->id;
                     if (!($flag = $modelDetailDetail->save(false))) {
                        break;
                     }
                  }
               }

            endforeach;
         }

         if ($flag) {
            $transaction->commit();
            $status = [
               'code' => 1,
               'message' => 'Commit'
            ];
         } else {
            $transaction->rollBack();
            $status = [
               'code' => 0,
               'message' => 'Roll Back'
            ];
         }
      } catch (Exception $e) {
         $transaction->rollBack();
         $status = [
            'code' => 0,
            'message' => 'Roll Back ' . $e->getMessage(),
         ];
      }

      return $status;
   }

   public function getClaimPettyCashNotaDetailsHaveStockType()
   {
      return $this->hasMany(ClaimPettyCashNotaDetail::class, ['claim_petty_cash_nota_id' => 'id'])
         ->via('claimPettyCashNotas')
         ->where([
            'IS NOT', 'claim_petty_cash_nota_detail.barang_id', NULL
         ]);
   }

}