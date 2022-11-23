<?php

namespace app\models\active_queries;

/**
 * This is the ActiveQuery class for [[\app\models\QuotationTermAndCondition]].
 *
 * @see \app\models\QuotationTermAndCondition
 */
class QuotationTermAndConditionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\QuotationTermAndCondition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\QuotationTermAndCondition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
