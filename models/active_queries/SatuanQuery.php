<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Satuan;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Satuan]].
 *
 * @see \app\models\Satuan
 */
class SatuanQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Satuan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function map()
    {

        return ArrayHelper::map(parent::select('id,nama')->all(), 'id', 'nama');
    }

    /**
     * @inheritdoc
     * @return Satuan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}