<?php

namespace app\controllers;

use app\components\helpers\ArrayHelper;
use app\models\Inventaris;
use app\models\MaterialRequisitionDetailPenawaran;
use app\models\search\InventarisSearch;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * InventarisController implements the CRUD actions for Inventaris model.
 */
class InventarisController extends Controller
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
    * Lists all Inventaris models.
    * @return string
    */
   public function actionIndex(): string
   {
      $searchModel = new InventarisSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      $dataProviderForExportMenu = clone $dataProvider;
      $dataProviderForExportMenu->pagination = false;

      return $this->render('index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
         'dataProviderForExportMenu' => $dataProviderForExportMenu,
         'today' => Yii::$app->formatter->asDate(date('Y-m-d H:i'), 'php:d-m-Y H:i'),
      ]);
   }

   /**
    * Displays a single Inventaris model.
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
    * Finds the Inventaris model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Inventaris the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel(int $id): Inventaris
   {
      if (($model = Inventaris::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

   /**
    * Creates a new Inventaris model.
    * If creation is successful, the browser will be redirected to the 'index' page.
    * @return Response|string
    */
   public function actionCreate(): Response|string
   {
      $model = new Inventaris();
      $mrdp = MaterialRequisitionDetailPenawaran::find()->forInventaris();

      if ($this->request->isPost) {

         if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Inventaris: ' . $model->kode_inventaris . ' berhasil ditambahkan.');
            return $this->redirect(['index']);
         }

         $model->loadDefaultValues();
      }

      return $this->render('create', [
         'model' => $model,
         'mrdp' => $mrdp,
      ]);
   }

   /**
    * Updates an existing Inventaris model.
    * If update is successful, the browser will be redirected to the 'index' page with pagination URL
    * @param integer $id
    * @return Response|string
    * @throws NotFoundHttpException if the model cannot be found
    */
   public function actionUpdate(int $id): Response|string
   {
      $model = $this->findModel($id);
      $availableMrdp = MaterialRequisitionDetailPenawaran::find()->forInventaris();
      $defaultMrdp = [
         $model->material_requisition_detail_penawaran_id =>
            $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->nama
            . ' - ' . $model->materialRequisitionDetailPenawaran->vendor->nama
            . ' - ' . $model->materialRequisitionDetailPenawaran->purchaseOrder->nomor
            . ' - Masuk: ' . $model->quantity
            . ' ' . $model->materialRequisitionDetailPenawaran->materialRequisitionDetail->satuan->nama
      ];

      $mrdp = ArrayHelper::merge(
         $defaultMrdp,
         $availableMrdp
      );

      if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
         Yii::$app->session->setFlash('info', 'Inventaris: ' . $model->kode_inventaris . ' berhasil dirubah.');
         return $this->redirect(['index']);
      }

      return $this->render('update', [
         'model' => $model,
         'mrdp' => $mrdp,
      ]);
   }

   /**
    * Deletes an existing Inventaris model.
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

      Yii::$app->session->setFlash('danger', 'Inventaris: ' . $model->kode_inventaris . ' berhasil dihapus.');
      return $this->redirect(['index']);
   }
}