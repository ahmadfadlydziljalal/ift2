<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;

/**
 * This is the ActiveQuery class for [[\app\models\Rekening]].
 *
 * @see \app\models\Rekening
 */
class RekeningQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Rekening[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Rekening|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function map()
    {
        return ArrayHelper::map(parent::all(), 'id', 'atas_nama');
    }
}