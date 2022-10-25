<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Barang;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Barang]].
 *
 * @see \app\models\Barang
 */
class UserQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Barang|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


    /**
     * @inheritdoc
     * @return Barang[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function map()
    {
        return ArrayHelper::map(parent::orderBy('username')->all(), 'id', 'username');
    }


}