<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\Card;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

/**
 * This is the ActiveQuery class for [[\app\models\Card]].
 *
 * @see \app\models\Card
 */
class CardQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Card|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function map(string $mode = Card::GET_ALL)
    {

        $q = parent::select('card.id as id, card.nama as nama')
            ->joinWith(['cardBelongsTypes' => function ($cbt) {
                $cbt->joinWith('cardType', false);
            }], false);

        switch ($mode):

            case Card::GET_ALL:
                $q->groupBy('card.id');
                break;

            case Card::GET_ONLY_VENDOR:
                $q->where([
                    'card_type.kode' => 'V'
                ])->groupBy('card.id');
                break;

            case Card::GET_ONLY_TOKO_SAYA:
                $q->where([
                    'card_type.kode' => 'TS'
                ])->groupBy('card.id');
                break;

            case Card::GET_APART_FROM_TOKO_SAYA:
                $q->where([
                    '!=', 'card_type.kode', 'TS'
                ])->groupBy('card.id');
                break;

            default:
                throw new NotFoundHttpException('Mode Anda tidak didukung');
        endswitch;


        return ArrayHelper::map($q->all(), 'id', 'nama');
    }

    /**
     * @inheritdoc
     * @return Card[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}