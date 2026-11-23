<?php

namespace app\models\form;

use app\models\User;
use Yii;
use yii\base\Model;

class UserSwitchIdentityForm extends Model {

    public ?string $userId = null;

    public function rules(): array {
        return [
            ['userId', 'required']
        ];
    }

    public function switch(): bool {
        $user = User::findOne($this->userId);
        Yii::$app->user->switchIdentity($user, 84000);
        Yii::$app->session->setFlash('success', 'Sekarang anda berperan sebagai ' . $user->username);
        return true;
    }

    public function switchBack(): bool {
        $user = User::findOne(1);
        Yii::$app->user->switchIdentity($user, 84000);
        return true;
    }

}