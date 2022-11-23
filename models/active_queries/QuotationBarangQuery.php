<?php

namespace app\models\active_queries;

/**
 * This is the ActiveQuery class for [[\app\models\QuotationBarang]].
 *
 * @see \app\models\QuotationBarang
 */
class QuotationBarangQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\QuotationBarang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\QuotationBarang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
