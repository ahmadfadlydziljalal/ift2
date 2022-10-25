<?php

namespace app\models;

use app\models\active_queries\UserQuery;
use mdm\admin\models\User as MdmUser;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\httpclient\Exception;

/**
 * @property int $karyawan_id
 * */
class User extends MdmUser
{

    const SCENARIO_CREATE = 'create';
    const SCENARIO_WITH_SIHRD_INTEGRATION = 'with-sihrd-integration';

    public ?string $new_password = null;
    public ?string $repeat_password = null;
    public ?string $nama_karyawan = null;

    /**
     * @return array
     */
    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            [['username', 'email', 'new_password'], 'required', 'on' => self::SCENARIO_CREATE],
            [['id', 'karyawan_id'], 'unique', 'on' => self::SCENARIO_WITH_SIHRD_INTEGRATION],
            [['id', 'username', 'auth_key', 'password_hash', 'email', 'status',
                'created_at', 'updated_at', 'karyawan_id'], 'required', 'on' => self::SCENARIO_WITH_SIHRD_INTEGRATION],
            [['new_password', 'repeat_password'], 'string', 'min' => 6],
            [['repeat_password'], 'compare', 'compareAttribute' => 'new_password'],
            [['new_password', 'repeat_password'], 'required', 'when' => function ($model) {
                return (!empty($model->new_password));
            }, 'whenClient' => "function (attribute, value) {
                return ($('#user-new_password').val().length>0);
            }"],
            [['karyawan_id', 'nama_karyawan'], 'safe'],
            [['password_reset_token'], 'safe', 'on' => self::SCENARIO_WITH_SIHRD_INTEGRATION],
        ]);
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_WITH_SIHRD_INTEGRATION] = [
            'id',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email',
            'status',
            'created_at',
            'updated_at',
            'karyawan_id',
            'nama_karyawan'
        ];
        return $scenarios;
    }

    /**
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getSihrdUser()
    {
        $request = (new Client())
            ->createRequest()
            ->setMethod('GET')
            ->setUrl(Yii::$app->params['hrdUrl'] . '/api/users/' . $this->id);
        $request->headers->set('Authorization', 'Basic ' . base64_encode("$this->auth_key:null"));

        $response = $request->send();
        if (!$response->isOk) {
            return null;
        }

        return $response->data;
    }

    public function getSihrdKaryawan()
    {

        $request = (new Client())
            ->createRequest()
            ->setMethod('GET')
            ->setUrl(Yii::$app->params['hrdUrl'] . '/api/karyawans/' . $this->karyawan_id);
        $request->headers->set('Authorization', 'Basic ' . base64_encode($this->auth_key . ":null"));

        $response = $request->send();

        if (!$response->isOk) {
            return null;
        }

        return $response->data;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->saveCacheForImage();
    }

    /**
     * @return void
     */
    public function saveCacheForImage()
    {
        $key = 'sihrd-user-image' . $this->id;
        $cache = Yii::$app->cache;
        $data = $cache->get($key);

        if ($data === false) {

            // $data is not found in cache
            $data = false;

            // SIHRD identifikasi kalau user ada data karyawan nya,
            $sihrdUser = $this->sihrdUser;

            if (!is_null($sihrdUser)) {

                // SIHRD mem - provide photo karyawan
                if (!is_null($sihrdUser['photo_karyawan'])) {

                    $data = Html::img($sihrdUser['photo_karyawan'], [
                            'alt' => '',
                            'loading' => 'lazy',
                            'class' => 'user-photo-32'
                        ]) . ' ' .
                        Html::tag('span', $sihrdUser['nama_karyawan'], ['class' => 'text-center']);

                } else {

                    // SIHRD tidak mem - provide photo karyawan
                    $data = Html::img($sihrdUser['jenis_kelamin_karyawan'] != 'Perempuan' ?
                            Url::to('@web/images/avatar-male.png') :
                            Url::to('@web/images/avatar-female.png'), [
                            'alt' => '',
                            'loading' => 'lazy',
                            'class' => 'user-photo-32'
                        ]) . ' ' .
                        Html::tag('span', $sihrdUser['nama_karyawan'], ['class' => 'text-center']);
                }

            }

            // store $data in cache so that it can be retrieved next time, in second unit
            $cache->set($key, $data, 60 * 60);

            $this->saveCacheForStatusAsSameWithSiHrd($sihrdUser);

        }
    }

    /**
     * @param $sihrdUser
     * @return void
     */
    public function saveCacheForStatusAsSameWithSiHrd($sihrdUser)
    {
        $key = 'sihrd-user-same-as' . $this->id;
        $cache = Yii::$app->cache;
        $data = $cache->get($key);

        if ($data === false) {

            if (is_null($sihrdUser)) {
                $data = false;
            } else {
                $intersect = array_intersect(ArrayHelper::toArray($this), $sihrdUser);
                if ($intersect === ArrayHelper::toArray($this)) {
                    $data = 'Same';
                } else {
                    $data = 'Not Same';
                }
            }
        }

        $cache->set($key, $data, 60 * 60);
    }

    public function saveCacheForDataKaryawan()
    {
        $key = 'sihrd-karyawan' . $this->id;

        $cache = Yii::$app->cache;
        $data = $cache->get($key);

        if ($data === false) {
            $sihrdKaryawan = $this->sihrdKaryawan;
            $data = is_null($sihrdKaryawan) ? '' : $sihrdKaryawan;
        }

        $cache->set($key, $data, 60 * 60);
    }

    public function afterDelete()
    {
        Yii::$app->cache->delete('sihrd-user-image' . $this->id);
        Yii::$app->cache->delete('sihrd-user-same-as' . $this->id);
        Yii::$app->cache->delete('sihrd-karyawan' . $this->id);
        parent::afterDelete();
    }


    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

}