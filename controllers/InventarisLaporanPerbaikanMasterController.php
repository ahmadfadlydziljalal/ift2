<?php

namespace app\controllers;

use app\models\InventarisLaporanPerbaikanDetail;
use app\models\InventarisLaporanPerbaikanMaster;
use app\models\search\InventarisLaporanPerbaikanMasterSearch;
use app\models\Tabular;
use Exception;
use kartik\mpdf\Pdf;
use Mpdf\MpdfException;
use setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * InventarisLaporanPerbaikanMasterController implements the CRUD actions for InventarisLaporanPerbaikanMaster model.
 */
class InventarisLaporanPerbaikanMasterController extends Controller
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
    * Lists all InventarisLaporanPerbaikanMaster models.
    * @return string
    */
   public function actionIndex(): string
   {
      $searchModel = new InventarisLaporanPerbaikanMasterSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * Displays a single InventarisLaporanPerbaikanMaster model.
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

   /**
    * Finds the InventarisLaporanPerbaikanMaster model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return InventarisLaporanPerbaikanMaster the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel(int $id): InventarisLaporanPerbaikanMaster
   {
      if (($model = InventarisLaporanPerbaikanMaster::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

   /**
    * Creates a new InventarisLaporanPerbaikanMaster model.
    * @return string|Response
    */
   public function actionCreate(): Response|string
   {
      $request = Yii::$app->request;
      $model = new InventarisLaporanPerbaikanMaster();
      $modelsDetail = [new InventarisLaporanPerbaikanDetail()];

      if ($model->load($request->post())) {

         $modelsDetail = Tabular::createMultiple(InventarisLaporanPerbaikanDetail::class);
         Tabular::loadMultiple($modelsDetail, $request->post());

         //validate models
         $isValid = $model->validate();
         $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

         if ($isValid) {

            $transaction = InventarisLaporanPerbaikanMaster::getDb()->beginTransaction();

            try {

               if ($flag = $model->save(false)) {
                  foreach ($modelsDetail as $detail) :
                     $detail->inventaris_laporan_perbaikan_master_id = $model->id;
                     if (!($flag = $detail->save(false))) {
                        break;
                     }
                  endforeach;
               }

               if ($flag) {
                  $transaction->commit();
                  $status = ['code' => 1, 'message' => 'Commit'];
               } else {
                  $transaction->rollBack();
                  $status = ['code' => 0, 'message' => 'Roll Back'];
               }

            } catch (Exception $e) {
               $transaction->rollBack();
               $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
            }

            if ($status['code']) {
               Yii::$app->session->setFlash('success', 'InventarisLaporanPerbaikanMaster: ' . Html::a($model->nomor, ['view', 'id' => $model->id]) . " berhasil ditambahkan.");
               return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('danger', " InventarisLaporanPerbaikanMaster is failed to insert. Info: " . $status['message']);
         }
      }

      return $this->render('create', [
         'model' => $model,
         'modelsDetail' => empty($modelsDetail) ? [new InventarisLaporanPerbaikanDetail()] : $modelsDetail,
      ]);

   }

   /**
    * Updates an existing InventarisLaporanPerbaikanMaster model.
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
      $modelsDetail = !empty($model->inventarisLaporanPerbaikanDetails) ? $model->inventarisLaporanPerbaikanDetails : [new InventarisLaporanPerbaikanDetail()];

      if ($model->load($request->post())) {

         $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
         $modelsDetail = Tabular::createMultiple(InventarisLaporanPerbaikanDetail::class, $modelsDetail);

         Tabular::loadMultiple($modelsDetail, $request->post());
         $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

         $isValid = $model->validate();
         $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

         if ($isValid) {
            $transaction = InventarisLaporanPerbaikanMaster::getDb()->beginTransaction();
            try {
               if ($flag = $model->save(false)) {

                  if (!empty($deletedDetailsID)) {
                     InventarisLaporanPerbaikanDetail::deleteAll(['id' => $deletedDetailsID]);
                  }

                  foreach ($modelsDetail as $detail) :
                     $detail->inventaris_laporan_perbaikan_master_id = $model->id;
                     if (!($flag = $detail->save(false))) {
                        break;
                     }
                  endforeach;
               }

               if ($flag) {
                  $transaction->commit();
                  $status = ['code' => 1, 'message' => 'Commit'];
               } else {
                  $transaction->rollBack();
                  $status = ['code' => 0, 'message' => 'Roll Back'];
               }
            } catch (Exception $e) {
               $transaction->rollBack();
               $status = ['code' => 0, 'message' => 'Roll Back ' . $e->getMessage(),];
            }

            if ($status['code']) {
               Yii::$app->session->setFlash('info', "InventarisLaporanPerbaikanMaster: " . Html::a($model->nomor, ['view', 'id' => $model->id]) . " berhasil di update.");
               return $this->redirect(['index']);
            }

            Yii::$app->session->setFlash('danger', " InventarisLaporanPerbaikanMaster is failed to updated. Info: " . $status['message']);
         }
      }

      return $this->render('update', [
         'model' => $model,
         'modelsDetail' => $modelsDetail
      ]);
   }

   /**
    * Delete an existing InventarisLaporanPerbaikanMaster model.
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

      Yii::$app->session->setFlash('danger', " InventarisLaporanPerbaikanMaster : " . $model->nomor . " berhasil dihapus.");
      return $this->redirect(['index']);
   }

   /**
    * @param $id
    * @return string
    * @throws NotFoundHttpException
    * @throws MpdfException
    * @throws CrossReferenceException
    * @throws PdfParserException
    * @throws PdfTypeException
    * @throws InvalidConfigException
    */
   public function actionPrintToPdf($id): string
   {
      /** @var Pdf $pdf */
      $pdf = Yii::$app->pdfWithLetterhead;
      $pdf->content = $this->renderPartial('print_to_pdf', [
         'model' => $this->findModel($id),
      ]);
      return $pdf->render();
   }
}