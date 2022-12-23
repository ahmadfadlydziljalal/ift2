<?php

namespace app\controllers;

use app\models\Barang;
use app\models\BarangSatuan;
use app\models\Satuan;
use app\models\search\BarangSearch;
use app\models\Tabular;
use Exception;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * BarangController implements the CRUD actions for Barang model.
 */
class BarangController extends Controller
{
   /**
    * @inheritdoc
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
    * Lists all Barang models.
    * @return string
    */
   public function actionIndex(): string
   {
      $searchModel = new BarangSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * Creates a new Barang model.
    * @return string|Response
    * @throws ServerErrorHttpException
    */
   public function actionCreate(): Response|string
   {
      $request = Yii::$app->request;
      $model = new Barang();
      $modelsDetail = [new BarangSatuan()];

      if ($model->load($request->post())) {

         // Re-create modelsDetail
         $modelsDetail = Tabular::createMultiple(BarangSatuan::class);
         Tabular::loadMultiple($modelsDetail, $request->post());

         // Validate models
         if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {

            if ($model->createWithDetails($modelsDetail)) {
               Yii::$app->session->setFlash('success', 'Barang: '
                  . Html::a($model->nama, ['view', 'id' => $model->id]) . " berhasil ditambahkan."
               );
               return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('danger', " Barang is failed to insert.");
         }
      }

      return $this->render('create', [
         'model' => $model,
         'modelsDetail' => empty($modelsDetail) ? [new BarangSatuan()] : $modelsDetail,
      ]);

   }

   /**
    * Displays a single Barang model.
    * @param integer $id
    * @return string
    * @throws HttpException
    */
   public function actionView(int $id): string
   {
      return $this->render('view', [
         'model' => $this->findModel($id),
      ]);
   }

   public function actionFindAvailableHarga(): array
   {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return [
         'data' => BarangSatuan::findOne([
            'barang_id' => (int)Yii::$app->request->post('barangId'),
            'satuan_id' => (int)Yii::$app->request->post('satuanId'),
            'vendor_id' => (int)Yii::$app->request->post('vendorId'),

         ]),
         'barangId' => (int)Yii::$app->request->post('barangId'),
         'vendorId' => (int)Yii::$app->request->post('vendorId'),
         'satuanId' => (int)Yii::$app->request->post('satuanId'),

      ];
   }

   /**
    * Updates an existing Barang model.
    * If update is successful, the browser will be redirected to the 'index' page with pagination URL
    * @param integer $id
    * @return Response|string
    * @throws HttpException
    * @throws NotFoundHttpException
    */
   public function actionUpdate(int $id): Response|string
   {
      $request = Yii::$app->request;
      $model = $this->findModel($id);
      $modelsDetail = !empty($model->barangSatuans)
         ? $model->barangSatuans :
         [new BarangSatuan()];

      if ($model->load($request->post())) :

         $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
         $modelsDetail = Tabular::createMultiple(BarangSatuan::class, $modelsDetail);

         Tabular::loadMultiple($modelsDetail, $request->post());
         $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

         if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {
            if ($model->updateWithDetails($modelsDetail, $deletedDetailsID)) return $this->redirect(['barang/view', 'id' => $id]);
         }

      endif;

      return $this->render('update', [
         'model' => $model,
         'modelsDetail' => $modelsDetail
      ]);
   }

   /**
    * Delete an existing Barang model.
    * @param integer $id
    * @return Response
    * @throws HttpException
    * @throws NotFoundHttpException
    * @throws Throwable
    * @throws StaleObjectException
    */
   public function actionDelete(int $id): Response
   {
      $model = $this->findModel($id);
      $model->delete();

      Yii::$app->session->setFlash('danger', " Barang : " . $model->nama . " berhasil dihapus.");
      return $this->redirect(['index']);
   }

   /**
    * Digunakan pada DepDrop
    * @return array|string[]
    */
   public function actionDepdropFindBarangByTipePembelian(): array
   {
      Yii::$app->response->format = Response::FORMAT_JSON;

      if (isset($_POST['depdrop_parents'])) {

         $parents = $_POST['depdrop_parents'];
         if ($parents != null) {
            $out = Barang::find()->byTipePembelian($parents[0]);
            if (isset($out[0])) {
               return ['output' => $out, 'selected' => $out[0]];
            }
            return ['output' => $out, 'selected' => ''];
         }
      }
      return ['output' => '', 'selected' => ''];
   }

   public function actionDepdropFindSatuanByBarang(): array
   {
      Yii::$app->response->format = Response::FORMAT_JSON;

      if (isset($_POST['depdrop_parents'])) {
         $parents = $_POST['depdrop_parents'];
         if ($parents != null) {

            $out = BarangSatuan::find()->availableSatuan($parents[0]);
            if (isset($out[0])) {
               return ['output' => $out, 'selected' => $out[0]];
            }

            $allSatuan = Satuan::find()->mapIdName();
            return ['output' => $allSatuan, 'selected' => $allSatuan[0]];
         }
      }
      return ['output' => '', 'selected' => ''];
   }

   /**
    * Digunakan pada DepDrop
    * @return array|string[]
    */
   public function actionDepdropFindVendorByBarangDanSatuan(): array
   {
      Yii::$app->response->format = Response::FORMAT_JSON;

      $out = [];
      if (isset($_POST['depdrop_parents'])) {

         $ids = $_POST['depdrop_parents'];
         $barangId = empty($ids[0]) ? null : $ids[0];
         $satuanId = empty($ids[1]) ? null : $ids[1];

         if ($barangId != null) {
            $data = BarangSatuan::find()->availableVendor($barangId, $satuanId);
            return ['output' => $data, 'selected' => ''];
         }
      }
      return ['output' => '', 'selected' => ''];
   }

   /**
    * @param $id
    * @return string
    * @throws NotFoundHttpException
    */
   public function actionUploadPhoto($id): string
   {
      $model = $this->findModel($id);
      return $this->render('_form_upload_photo', [
         'model' => $model
      ]);
   }

   /**
    * @return array|void
    * @throws NotFoundHttpException
    * @throws \yii\db\Exception
    */
   public function actionHandleUploadPhoto()
   {
      if (empty($_FILES['file_data'])) {
         echo Json::encode(['error', 'No files found for upload']);
         return;
      }

      $model = $this->findModel(Yii::$app->request->post('id'));
      $error = $model->upload($_FILES['file_data'], Yii::$app->request->post());

      Yii::$app->response->format = Response::FORMAT_JSON;
      return empty($error)
         ? ['success', $_FILES['file_data']]
         : ['error', 'Error While uploading image, contact the system administrator' . $error];
   }

   /**
    * Finds the Barang model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return Barang the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel(int $id): Barang
   {
      if (($model = Barang::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }
}