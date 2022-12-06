<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Status;
use yii\db\ActiveQuery;
use yii\helpers\Inflector;

/**
 * This is the ActiveQuery class for [[\app\models\Status]].
 *
 * @see \app\models\Status
 */
class StatusQuery extends ActiveQuery
{
   /*public function active()
   {
       $this->andWhere('[[status]]=1');
       return $this;
   }*/

   /**
    * @inheritdoc
    * @return Status|array|null
    */
   public function one($db = null)
   {
      return parent::one($db);
   }

   public function map(string $sectionName): array
   {
      return ArrayHelper::map(parent::where([
         'section' => $sectionName
      ])->all(), 'id', function ($model) {
         return Inflector::humanize(str_replace("-", " ", $model->key));
      });
   }

   /**
    * @inheritdoc
    * @return Status[]|array
    */
   public function all($db = null)
   {
      return parent::all($db);
   }
}