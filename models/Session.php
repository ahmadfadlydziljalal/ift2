<?php

namespace app\models;

use app\models\base\Session as BaseSession;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "session".
 */
class Session extends BaseSession
{

    public function behaviors(): array
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules(): array
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, [
            'id' => 'user_id'
        ]);
    }
}