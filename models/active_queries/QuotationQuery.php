<?php

namespace app\models\active_queries;

use app\models\Quotation;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Quotation]].
 *
 * @see \app\models\Quotation
 */
class QuotationQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return Quotation[]|array
    */
   public function all($db = null)
   {
      return parent::all($db);
   }

   /**
    * @inheritdoc
    * @return Quotation|array|null
    */
   public function one($db = null)
   {
      return parent::one($db);
   }

}