<?php

namespace app\models\active_queries;

use app\components\helpers\ArrayHelper;
use app\models\CardOwnEquipment;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\CardOwnEquipment]].
 *
 * @see \app\models\CardOwnEquipment
 */
class CardOwnEquipmentQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return CardOwnEquipment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byCardId(int $customer_id): array
    {
        return ArrayHelper::map(parent::where([
            'card_id' => $customer_id
        ])->all(), 'id', function ($model) {
            return $model->nama . ' ' . $model->serial_number;
        });
    }

    /**
     * @inheritdoc
     * @return CardOwnEquipment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}