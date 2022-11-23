<?php

namespace app\models\active_queries;

/**
 * This is the ActiveQuery class for [[\app\models\QuotationAnotherFee]].
 *
 * @see \app\models\QuotationAnotherFee
 */
class QuotationAnotherFeeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\QuotationAnotherFee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\QuotationAnotherFee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
