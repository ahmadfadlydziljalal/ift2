<?php

namespace app\models\active_queries;

/**
 * This is the ActiveQuery class for [[\app\models\MaterialRequisition]].
 *
 * @see \app\models\MaterialRequisition
 */
class MaterialRequisitionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\MaterialRequisition[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\MaterialRequisition|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
