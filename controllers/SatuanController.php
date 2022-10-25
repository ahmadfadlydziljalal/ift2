<?php

namespace app\controllers;

use Yii;
use app\models\Satuan;
use app\models\search\SatuanSearch;
use Throwable;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\StaleObjectException;
use yii\web\Response;

/**
* SatuanController implements the CRUD actions for Satuan model.
*/
class SatuanController extends Controller
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
    * Lists all Satuan models.
    * @return string
    */
    public function actionIndex() : string {
        $searchModel = new SatuanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
    * Displays a single Satuan model.
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
    * Creates a new Satuan model.
    * If creation is successful, the browser will be redirected to the 'index' page.
    * @return Response|string
    */
    public function actionCreate(){
        $model = new Satuan();

        if ($this->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $model->save()){
                Yii::$app->session->setFlash('success',  'Satuan: ' . $model->id.  ' berhasil ditambahkan.');
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
    * Updates an existing Satuan model.
    * If update is successful, the browser will be redirected to the 'index' page with pagination URL
    * @param integer $id
    * @return Response|string
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionUpdate(int $id){
        $model = $this->findModel($id);

        if($this->request->isPost && $model->load($this->request->post()) && $model->save()){
            Yii::$app->session->setFlash('info',  'Satuan: ' . $model->id.  ' berhasil dirubah.');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
    * Deletes an existing Satuan model.
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

        Yii::$app->session->setFlash('danger',  'Satuan: ' . $model->id.  ' berhasil dihapus.');
        return $this->redirect(['index']);
    }

    /**
    * Finds the Satuan model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Satuan the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel(int $id) : Satuan {
        if (($model = Satuan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}