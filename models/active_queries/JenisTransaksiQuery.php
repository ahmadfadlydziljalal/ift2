<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\JenisTransaksi;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\JenisTransaksi]].
 *
 * @see \app\models\JenisTransaksi
 */
class JenisTransaksiQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return JenisTransaksi|array|null
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
     * @return JenisTransaksi[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

}