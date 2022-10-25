<?php

namespace app\controllers;

use app\models\CardPersonInCharge;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CardPersonInChargeController implements the CRUD actions for CardPersonInCharge model.
 */
class CardPersonInChargeController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Creates a new CardPersonInCharge model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreate(int $cardId)
    {
        $model = new CardPersonInCharge([
            'card_id' => $cardId
        ]);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'P.I.C: ' . $model->nama . ' berhasil ditambahkan.');
                return $this->redirect(['/card/view', 'id' => $model->card_id]);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CardPersonInCharge model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', $model->nama . ' berhasil dirubah.');
            return $this->redirect(['/card/view', 'id' => $model->card_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the CardPersonInCharge model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CardPersonInCharge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): CardPersonInCharge
    {
        if (($model = CardPersonInCharge::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing CardPersonInCharge model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger', 'CardPersonInCharge: ' . $model->nama . ' berhasil dihapus.');
        return $this->redirect(['index']);
    }
}