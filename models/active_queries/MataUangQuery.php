<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\MataUang;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\MataUang]].
 *
 * @see \app\models\MataUang
 */
class MataUangQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MataUang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return array
     */
    public function map(): array
    {
        return ArrayHelper::map(parent::all(), 'id', 'singkatan');
    }

    /**
     * @inheritdoc
     * @return MataUang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}