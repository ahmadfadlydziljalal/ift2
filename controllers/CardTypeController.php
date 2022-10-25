<?php

namespace app\controllers;

use Yii;
use app\models\CardType;
use app\models\search\CardTypeSearch;
use Throwable;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\web\Response;

/**
* CardTypeController implements the CRUD actions for CardType model.
*/
class CardTypeController extends Controller
{
    /**
    * {@inheritdoc}
    */
    public function behaviors() : array
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
    * Lists all CardType models.
    * @return string
    */
    public function actionIndex() : string {
        $searchModel = new CardTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * Displays a single CardType model.
    * @param integer $id
    * @return string
    * @throws NotFoundHttpException
    */
    public function actionView(int $id) : string
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
    * Creates a new CardType model.
    * If creation is successful, the browser will be redirected to the 'index' page.
    * @return Response|string
    */
    public function actionCreate(){
        $model = new CardType();

        if ($this->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $model->save()){
                Yii::$app->session->setFlash('success',  'CardType: ' . $model->nama.  ' berhasil ditambahkan.');
                return $this->redirect(['index']);
            } else {
                $model->loadDefaultValues();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
    * Updates an existing CardType model.
    * If update is successful, the browser will be redirected to the 'index' page with pagination URL
    * @param integer $id
    * @return Response|string
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionUpdate(int $id){
        $model = $this->findModel($id);

        if($this->request->isPost && $model->load($this->request->post()) && $model->save()){
            Yii::$app->session->setFlash('info',  'CardType: ' . $model->nama.  ' berhasil dirubah.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
    * Deletes an existing CardType model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return Response
    * @throws NotFoundHttpException if the model cannot be found
    * @throws StaleObjectException
    * @throws Throwable
    */
    public function actionDelete(int $id) : Response {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('danger',  'CardType: ' . $model->nama.  ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
    * Finds the CardType model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return CardType the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel(int $id) : CardType {
        if (($model = CardType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}