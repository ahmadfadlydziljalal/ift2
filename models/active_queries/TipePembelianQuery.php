<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\TipePembelian;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\TipePembelian]].
 *
 * @see TipePembelian
 */
class TipePembelianQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return TipePembelian|array|null
    */
   public function one($db = null)
   {
      return parent::one($db);
   }

   public function map(array $tipe = []): array
   {
      return $tipe
         ? ArrayHelper::map(
            parent::where(['in', 'id', $tipe])->all(),
            'id',
            'nama'
         )
         : ArrayHelper::map(
            parent::all(),
            'id',
            'nama'
         );
   }

   /**
    * @inheritdoc
    * @return TipePembelian[]|array
    */
   public function all($db = null)
   {
      return parent::all($db);
   }
}