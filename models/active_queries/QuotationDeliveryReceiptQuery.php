<?php

namespace app\models\active_queries;

use app\models\QuotationDeliveryReceipt;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\QuotationDeliveryReceipt]].
 *
 * @see \app\models\QuotationDeliveryReceipt
 */
class QuotationDeliveryReceiptQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return QuotationDeliveryReceipt[]|array
    */
   public function all($db = null)
   {
      return parent::all($db);
   }

   /**
    * @inheritdoc
    * @return QuotationDeliveryReceipt|array|null
    */
   public function one($db = null)
   {
      return parent::one($db);
   }


}