<?php

namespace app\models;

use app\components\helpers\ArrayHelper;
use app\components\SihrdAuthClient;
use Yii;
use yii\base\Model;
use yii\db\Exception;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model {
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }


    public function loginByOauth2ResourceOwnerPassword(SihrdAuthClient $client): bool|User {
        # Set Session
        Yii::$app->session->set('jwt', $client->getAccessToken());

        # Get attribute dari OAuth2
        $attributes = $client->getUserAttributes();

        $session = Yii::$app->session;
        $session->set('id_karyawan', ArrayHelper::getValue($attributes, 'karyawan.id'));
        $session->set('nama_karyawan', ArrayHelper::getValue($attributes, 'karyawan.nama'));
        $session->set('photo_karyawan', ArrayHelper::getValue($attributes, 'karyawan.photo'));
        $session->set('nama_panggilan_karyawan', ArrayHelper::getValue($attributes, 'karyawan.nama_panggilan'));
        $session->set('username', ArrayHelper::getValue($attributes, 'karyawan.nama_panggilan'));

        $auth = Auth::find()->where([
            'source'    => $client->getId(),
            'source_id' => ArrayHelper::getValue($attributes, 'user.id'),
        ])->one();

        # Cek kalau user sudah terdaftar dari SIHRD atau another OAuth2 ?
        if ($auth) {
            # Update data terakhir user tersebut By User info
            $this->updateUser($auth->user, $attributes, $client);
            return $auth->user;
        } else {
            # User belum terdaftar ...
            return $this->createUser($attributes, $client);
        }
    }

    /**
     * @param $attributes
     * @param $client
     * @return User
     * @throws Exception
     */
    protected function createUser($attributes, $client): User {
        $user = new User([
            'id'       => ArrayHelper::getValue($attributes, 'user.id'),
            'username' => ArrayHelper::getValue($attributes, 'user.username'),
            'email'    => ArrayHelper::getValue($attributes, 'user.email'),
            'password' => $this->password,
            /*'nama_karyawan'  => ArrayHelper::getValue($attributes, 'karyawan.nama'),*/
            /* 'nama_panggilan' => ArrayHelper::getValue($attributes, 'karyawan.nama_panggilan'),
             'jenis_kelamin'  => ArrayHelper::getValue($attributes, 'karyawan.jenis_kelamin'),
             'kota_id'        => ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.kota_id'),
             'perusahaan_id'  => ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.perusahaan_id'),
             'cabang_id'      => ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.cabang_id'),
             'departemen_id'  => ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.departemen_id'),
             'jabatan_id'     => ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.jabatan_id'),
             'bawahan'        => ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.bawahan'),
             'data'           => $attributes,*/
        ]);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();

        if ($user->save()) {

            # Save sebagai AuthUser baru
            $auth = new Auth([
                'user_id'   => $user->id,
                'source'    => $client->getId(),
                'source_id' => (string)ArrayHelper::getValue($attributes, 'user.id'),
            ]);
            $auth->save();

            # Cek kalau user account tersebut di SIHRD adalah super-admin ?
            $authManager = Yii::$app->authManager;
            if (ArrayHelper::getValue($attributes, 'roles.super-admin')) {
                $sa = $authManager->getRole('super-admin');
                $authManager->assign($sa, $user->id);
            }

            # Set flash ke UI untuk informasi ke user
            Yii::$app->session->setFlash('success', 'Anda sudah bergabung via ' . ucfirst($client->getId()) . ', dan Selamat Datang...! ');

            # Tanpa OTP, Assign user berhasil login
            Yii::$app->user->login($user, 86400);
        }

        return $user;
    }

    /**
     * @param $user
     * @param $attributes
     * @param $client
     * @return void
     * @throws Exception
     */
    protected function updateUser($user, $attributes, $client): void {

        $user->id = ArrayHelper::getValue($attributes, 'user.id');
        $user->email = ArrayHelper::getValue($attributes, 'user.email');
        $user->username = ArrayHelper::getValue($attributes, 'user.username');
        /*  $user->nama_karyawan = ArrayHelper::getValue($attributes, 'karyawan.nama');
          $user->nama_panggilan = ArrayHelper::getValue($attributes, 'karyawan.nama_panggilan');
          $user->jenis_kelamin = ArrayHelper::getValue($attributes, 'karyawan.jenis_kelamin');
          $user->kota_id = ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.kota_id');
          $user->perusahaan_id = ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.perusahaan_id');
          $user->cabang_id = ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.cabang_id');
          $user->departemen_id = ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.departemen_id');
          $user->jabatan_id = ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.jabatan_id');
          $user->bawahan = ArrayHelper::getValue($attributes, 'karyawan.jabatan_utama.bawahan');
          $user->data = $attributes;*/

        # Update user di database
        $user->save(false);

        # Set flash ke UI untuk informasi ke user
        Yii::$app->session->setFlash('success', 'Login by ' . strtoupper($client->getId()) . ' berhasil dan Selamat Datang...! ');

        # Assign user berhasil login
        Yii::$app->user->login($user, 84000);
    }

}
