<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Card;
use app\models\Rekening;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Rekening]].
 *
 * @see \app\models\Rekening
 */
class RekeningQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Rekening|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function mapOnlyTokoSaya()
    {
        $card = Card::find()->map(Card::GET_ONLY_TOKO_SAYA);

        return ArrayHelper::map(parent::where([
            'IN', 'card_id', array_keys($card)
        ])->all(), 'id', 'atas_nama');
    }

    public function map()
    {
        return ArrayHelper::map(parent::all(), 'id', 'atas_nama');
    }

    /**
     * @inheritdoc
     * @return Rekening[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}