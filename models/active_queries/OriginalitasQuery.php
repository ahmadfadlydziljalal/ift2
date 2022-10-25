<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Originalitas;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Originalitas]].
 *
 * @see \app\models\Originalitas
 */
class OriginalitasQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Originalitas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function map(): array
    {
        return ArrayHelper::map(parent::all(), 'id', 'nama');
    }

    /**
     * @inheritdoc
     * @return Originalitas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}