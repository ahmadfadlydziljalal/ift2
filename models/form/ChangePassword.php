<?php


namespace app\models\form;


use app\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ChangePassword extends Model {

    public $new_password, $repeat_password;

    public $id;

    public function init() {
        parent::init();
        $this->id = Yii::$app->user->id;
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['new_password', 'repeat_password'], 'required'],
            [['new_password', 'repeat_password'], 'string', 'min' => 6],
            [['repeat_password'], 'compare', 'compareAttribute' => 'new_password'],
        ];
    }

    public function attributeLabels(): array
    {
        return ArrayHelper::merge(
            parent::attributeLabels(), [
                'new_password' => 'Password Baru',
                'repeat_password' => 'Ulangi Password',
            ]
        );
    }

    public function change(): bool
    {
        if ($this->validate()) {
            /* @var $user User */
            $user = Yii::$app->user->identity;
            $user->setPassword($this->new_password);
            $user->generateAuthKey();
            if ($user->save()) {
                return true;
            }
        }

        return false;
    }
}