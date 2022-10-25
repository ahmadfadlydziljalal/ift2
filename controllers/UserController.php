<?php

namespace app\controllers;

use app\components\helpers\ArrayHelper;
use app\models\User;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    /**
     * @return string|Response
     * @throws Exception
     */
    public function actionCreate()
    {

        $model = new User([
            'scenario' => User::SCENARIO_CREATE
        ]);

        if ($model->load(Yii::$app->request->post())) {

            $model->setPassword($model->new_password);
            $model->auth_key = Yii::$app->security->generateRandomString();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', $model->new_password);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal membuat sebuah user account');
            }

            return $this->redirect(['/admin/user/view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model
        ]);

    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = User::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post())) {

            $model->setPassword($model->new_password);
            if ($model->save()) {
                Yii::$app->session->setFlash('success', $model->new_password);
                return $this->redirect(['/admin/user/view', 'id' => $model->id]);
            }
            Yii::$app->session->setFlash('error', 'Gagal membuat sebuah user account');

        }

        return $this->render('create', [
            'model' => $model
        ]);

    }

    /**
     * @param $id
     * @return User|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ?User
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return string|Response
     */
    public function actionCreateWithSihrdIntegration()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_WITH_SIHRD_INTEGRATION;
        $model->detachBehaviors();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Akun ' . $model->username . ' berhasil dibuat');
                return $this->redirect(['/admin/user/view', 'id' => $model->id]);
            }

            Yii::$app->session->setFlash('error', $model->getFirstErrors());
        }

        return $this->render('create_with_si_hrd_integration', [
            'model' => $model,
            'response' => null,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionUpdateWithSihrdIntegration($id)
    {

        $model = $this->findModel($id);
        $request = (new Client())
            ->createRequest()
            ->setMethod('GET')
            ->setUrl(Yii::$app->params['hrdUrl'] . '/api/users/' . $model->id);
        $request->headers->set('Authorization', 'Basic ' . base64_encode($model->auth_key.":null"));

        $response = $request->send();
        if (!$response->isOk) {
            new NotFoundHttpException('SIHRD: User tidak ditemukan');
        }

        $model->scenario = User::SCENARIO_WITH_SIHRD_INTEGRATION;
        $model->id = $response->data['id'];
        $model->username = $response->data['username'];
        $model->auth_key = $response->data['auth_key'];
        $model->password_hash = $response->data['password_hash'];
        $model->password_reset_token = $response->data['password_reset_token'];
        $model->email = $response->data['email'];
        $model->status = $response->data['status'];
        $model->created_at = $response->data['created_at'];
        $model->updated_at = $response->data['updated_at'];
        $model->karyawan_id = $response->data['karyawan_id'];

        $model->detachBehaviors();
        if ($model->save()) {
            Yii::$app->session->setFlash('success', $model->username . ', SIHRD => SIPRC sudah sama datanya');
        }else{
            Yii::$app->session->setFlash('error', 'Gagal meng-update sebuah user account');
        }

        return $this->redirect(!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : ['/admin/user/index'] );

    }

}