<?php

namespace app\controllers;

use app\models\CardOwnEquipment;
use app\models\search\CardOwnEquipmentSearch;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * CardOwnEquipmentController implements the CRUD actions for CardOwnEquipment model.
 */
class CardOwnEquipmentController extends Controller
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
     * Lists all CardOwnEquipment models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new CardOwnEquipmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CardOwnEquipment model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Finds the CardOwnEquipment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CardOwnEquipment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): CardOwnEquipment
    {
        if (($model = CardOwnEquipment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new CardOwnEquipment model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return Response|string
     */
    public function actionCreate(int $cardId)
    {
        $model = new CardOwnEquipment([
            'card_id' => $cardId
        ]);

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Card Equipment: ' . $model->nama . ' berhasil ditambahkan.');
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
     * Updates an existing CardOwnEquipment model.
     * If update is successful, the browser will be redirected to the 'index' page with pagination URL
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'Card Equipment: ' . $model->nama . ' berhasil dirubah.');
            return $this->redirect(['/card/view', 'id' => $model->card_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CardOwnEquipment model.
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

        Yii::$app->session->setFlash('danger', 'CardOwnEquipment: ' . $model->id . ' berhasil dihapus.');
        return $this->redirect(['index']);
    }
}