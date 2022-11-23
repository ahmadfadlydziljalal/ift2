<?php

namespace app\models\active_queries;

/**
 * This is the ActiveQuery class for [[\app\models\CardPersonInCharge]].
 *
 * @see \app\models\CardPersonInCharge
 */
class CardPersonInChargeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return \app\models\CardPersonInCharge[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\CardPersonInCharge|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function picAsAttendant($cardId)
    {
        return parent::joinWith('card')
            ->where([
                'card_id' => $cardId
            ])
            ->all();
    }
}
