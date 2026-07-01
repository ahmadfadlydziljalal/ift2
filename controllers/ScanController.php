<?php

namespace app\controllers;

use app\models\Stock;
use app\storage\SihrdAuthenticator;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

class ScanController extends Controller {

    /**
     * Try authenticating WebView requests with Bearer token. If no session and no Bearer token,
     * redirect normal browsers to login. Keep the request non-persistent (no session login).
     */
    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $user = Yii::$app->user;
        if ($user->isGuest) {
            $authHeader = Yii::$app->request->getHeaders()->get('Authorization');

            // If Authorization: Bearer ... is provided (e.g., Android WebView), try token auth
            if ($authHeader && stripos($authHeader, 'Bearer ') === 0) {
                $auth = new SihrdAuthenticator();
                try {
                    $identity = $auth->authenticate($user, Yii::$app->request, Yii::$app->response);
                    if ($identity) {
                        // Set identity for this request only (do not create a persistent session)
                        $user->setIdentity($identity);
                        return true;
                    }
                } catch (UnauthorizedHttpException $e) {
                    Yii::$app->response->statusCode = 401;
                    Yii::$app->response->data = [
                        'name' => 'Unauthorized',
                        'message' => $e->getMessage(),
                    ];
                    return false;
                } catch (\Throwable $e) {
                    Yii::error($e, __METHOD__);
                    Yii::$app->response->statusCode = 401;
                    Yii::$app->response->data = [
                        'name' => 'Unauthorized',
                        'message' => 'Invalid token.',
                    ];
                    return false;
                }
            }

            // No Bearer token present -> treat as normal browser: redirect to login
            Yii::$app->getResponse()->redirect(['/site/login'])->send();
            return false;
        }

        return true;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionIndex($object = 'stock', $params = []): string {
        $this->layout = 'scan';
        if ($object == 'stock') {
            $data = (new Stock());
            $data->setAttributes((new Stock())->getData()->where([
                'id' => $params['id'] ?? null,
            ])->one());

            /** @var array $data */
            return $this->render('index', [
                'data' => $data,
            ]);
        }
        throw new NotFoundHttpException('Halaman tidak ditemukan');
    }
}