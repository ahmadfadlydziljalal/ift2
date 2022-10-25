<?php

namespace app\models\active_queries;

use app\models\Faktur;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Faktur]].
 *
 * @see \app\models\Faktur
 */
class FakturQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Faktur[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Faktur|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function countHariIni()
    {
        return parent::where([
            'tanggal_faktur' => Yii::$app->formatter->asDate(date('Y-m-d'), 'php:Y-m-d')
        ])->count();
    }
}