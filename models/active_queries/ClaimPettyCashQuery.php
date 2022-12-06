<?php

namespace app\models\active_queries;

use app\models\ClaimPettyCash;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\ClaimPettyCash]].
 *
 * @see \app\models\ClaimPettyCash
 */
class ClaimPettyCashQuery extends ActiveQuery
{


   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return ClaimPettyCash|array|null
    */
   public function one($db = null)
   {
      return parent::one($db);
   }

   public function byNomor(mixed $q): array
   {
      return parent::select([
         'id' => 'id',
         'text' => 'nomor'
      ])->where([
         'LIKE', 'nomor', $q
      ])
         ->asArray()
         ->all();
   }

   /**
    * @inheritdoc
    * @return ClaimPettyCash[]|array
    */
   public function all($db = null)
   {
      return parent::all($db);
   }
}