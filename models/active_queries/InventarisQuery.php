<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Inventaris;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Inventaris]].
 *
 * @see Inventaris
 */
class InventarisQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return Inventaris|array|null
    */
   public function one($db = null): Inventaris|array|null
   {
      return parent::one($db);
   }

   /**
    * @return array
    */
   public function map(): array
   {
      return ArrayHelper::map(parent::all(), 'id', 'kode_inventaris');
   }

   /**
    * @inheritdoc
    * @return Inventaris[]|array
    */
   public function all($db = null): array
   {
      return parent::all($db);
   }
}