<?php

namespace app\models\active_queries;

use app\models\TandaTerimaBarangDetail;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\TandaTerimaBarangDetail]].
 *
 * @see \app\models\TandaTerimaBarangDetail
 */
class TandaTerimaBarangDetailQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return TandaTerimaBarangDetail|array|null
    */
   public function one($db = null)
   {
      return parent::one($db);
   }


   /**
    * @inheritdoc
    * @return TandaTerimaBarangDetail[]|array
    */
   public function all($db = null)
   {
      return parent::all($db);
   }
}