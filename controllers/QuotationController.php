<?php

namespace app\controllers;

use app\components\BarangQuotation;
use app\components\DeliveryReceiptQuotation;
use app\components\ServiceQuotation;
use app\components\TermConditionQuotation;
use app\models\form\LaporanOutgoingQuotation;
use app\models\Quotation;
use app\models\QuotationBarang;
use app\models\QuotationDeliveryReceipt;
use app\models\QuotationFormJob;
use app\models\search\QuotationSearch;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

/**
 * QuotationController implements the CRUD actions for Quotation model.
 */
class QuotationController extends Controller
{
   /**
    * {@inheritdoc}
    */
   #[ArrayShape(['verbs' => "array"])]
   public function behaviors(): array
   {
      return [
         'verbs' => [
            'class' => VerbFilter::class,
            'actions' => [
               'delete' => ['POST'],
               'delete-barang-quotation' => ['POST'],
               'delete-service-quotation' => ['POST'],
               'delete-term-and-condition' => ['POST'],
            ],
         ],
      ];
   }

   /**
    * @return string
    */
   public function actionIndex(): string
   {
      $searchModel = new QuotationSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * @param int $id
    * @return string
    * @throws NotFoundHttpException
    */
   public function actionView(int $id): string
   {
      return $this->render('view', [
         'model' => $this->findModel($id),
         'links' => [
            'master',
            'summary',
            'barang',
            'service',
            'term-and-condition',
            'form-job',
            'delivery-receipt'
         ],
      ]);
   }

   /**
    * @throws NotFoundHttpException
    */
   protected function findModel(int $id): Quotation
   {
      if (($model = Quotation::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

   /**
    * @return Response|string
    */
   public function actionCreate(): Response|string
   {
      $model = new Quotation();
      if ($this->request->isPost) {
         if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Quotation: ' . $model->nomor . ' berhasil ditambahkan.');
            return $this->redirect(['view', 'id' => $model->id]);
         } else {
            $model->loadDefaultValues();
         }
      }

      return $this->render('create', [
         'model' => $model,
      ]);
   }

   /**
    * @param int $id
    * @return Response|string
    * @throws NotFoundHttpException
    */
   public function actionUpdate(int $id): Response|string
   {
      $model = $this->findModel($id);

      if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
         Yii::$app->session->setFlash('info', 'Quotation: ' . $model->nomor . ' berhasil dirubah.');
         return $this->redirect(['quotation/view', 'id' => $id]);
      }

      return $this->render('update', [
         'model' => $model,
      ]);
   }

   /**
    * @param int $id
    * @return Response
    * @throws NotFoundHttpException
    * @throws StaleObjectException
    * @throws Throwable
    */
   public function actionDelete(int $id): Response
   {
      $model = $this->findModel($id);
      $model->delete();

      Yii::$app->session->setFlash('danger', 'Quotation: ' . $model->nomor . ' berhasil dihapus.');
      return $this->redirect(['index']);
   }

   /**
    * @param $id
    * @return string
    * @throws NotFoundHttpException
    */
   public function actionPrint($id): string
   {
      $this->layout = 'print';
      return $this->render('preview_print', [
         'model' => $this->findModel($id),
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    */
   public function actionCreateBarangQuotation($id): Response|string
   {
      $component = Yii::createObject([
         'class' => BarangQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_CREATE_BARANG_QUOTATION,
      ]);

      if ($this->request->isPost && $component->quotation->load($this->request->post())) {
         if ($component->create()) {
            return $this->redirect(['quotation/view', 'id' => $id]);
         }
      }

      return $this->render('create_barang_quotation', [
         'quotation' => $component->quotation,
         'models' => $component->quotationBarangs,
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    */
   public function actionUpdateBarangQuotation($id): Response|string
   {
      $component = Yii::createObject([
         'class' => BarangQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_UPDATE_BARANG_QUOTATION,
      ]);

      if ($this->request->isPost && $component->quotation->load($this->request->post())) {
         if ($component->update()) {
            return $this->redirect(['quotation/view', 'id' => $id]);
         }
      }

      return $this->render('update_barang_quotation', [
         'quotation' => $component->quotation,
         'models' => $component->quotationBarangs,
      ]);
   }

   /**
    * @param $id
    * @return Response
    * @throws InvalidConfigException
    */
   public function actionDeleteBarangQuotation($id): Response
   {
      $component = Yii::createObject([
         'class' => BarangQuotation::class,
         'quotationId' => $id
      ]);
      $component->delete();
      return $this->redirect(['quotation/view', 'id' => $id]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws NotFoundHttpException
    * @throws Exception
    */
   public function actionCreateServiceQuotation($id): Response|string
   {
      $component = Yii::createObject([
         'class' => ServiceQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_CREATE_SERVICE_QUOTATION,
      ]);
      if ($component->quotation->load($this->request->post())) {
         if ($component->create()) {
            return $this->redirect(['quotation/view', 'id' => $component->quotation->id]);
         }
      }
      return $this->render('create_service_quotation', [
         'quotation' => $component->quotation,
         'models' => $component->quotationServices,
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws Exception
    * @throws InvalidConfigException
    */
   public function actionUpdateServiceQuotation($id): Response|string
   {

      $component = Yii::createObject([
         'class' => ServiceQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_UPDATE_SERVICE_QUOTATION,
      ]);
      if ($this->request->isPost && $component->quotation->load($this->request->post())) {
         if ($component->update()) {
            return $this->redirect(['quotation/view', 'id' => $id]);
         }
      }
      return $this->render('update_service_quotation', [
         'quotation' => $component->quotation,
         'models' => $component->quotationServices,
      ]);
   }

   /**
    * @param $id
    * @return Response
    * @throws InvalidConfigException
    */
   public function actionDeleteServiceQuotation($id): Response
   {
      $component = Yii::createObject([
         'class' => ServiceQuotation::class,
         'quotationId' => $id
      ]);
      $component->delete();
      return $this->redirect(['quotation/view', 'id' => $id]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws Exception
    * @throws InvalidConfigException
    */
   public function actionCreateTermAndCondition($id): Response|string
   {
      $component = Yii::createObject([
         'class' => TermConditionQuotation::class,
         'quotationId' => $id,
         'scenario' => Quotation::SCENARIO_CREATE_TERM_AND_CONDITION,
      ]);

      if ($this->request->isPost) {
         if ($component->create()) {
            return $this->redirect(['quotation/view', 'id' => $component->quotation->id]);
         }
      }

      return $this->render('create_term_and_condition', [
         'quotation' => $component->quotation,
         'models' => $component->quotationTermAndConditions,
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws Exception
    * @throws InvalidConfigException
    */
   public function actionUpdateTermAndCondition($id): Response|string
   {
      $component = Yii::createObject(['class' => TermConditionQuotation::class, 'quotationId' => $id, 'scenario' => Quotation::SCENARIO_UPDATE_TERM_AND_CONDITION,]);

      if ($this->request->isPost) {
         if ($component->update()) {
            return $this->redirect(['quotation/view', 'id' => $id]);
         }
      }

      return $this->render('update_term_and_condition', [
         'quotation' => $component->quotation,
         'models' => $component->quotationTermAndConditions,
      ]);
   }

   /**
    * @param $id
    * @return Response
    * @throws InvalidConfigException
    */
   public function actionDeleteTermAndCondition($id): Response
   {
      $component = Yii::createObject(['class' => TermConditionQuotation::class, 'quotationId' => $id]);
      $component->delete();
      return $this->redirect(['quotation/view', 'id' => $id]);
   }

   /**
    * @param $id
    * @return string|Response
    * @throws Exception
    * @throws NotFoundHttpException
    */
   public function actionCreateFormJob($id): Response|string
   {
      $quotation = $this->findModel($id);
      $model = new QuotationFormJob(['quotation_id' => $id]);

      if ($model->load($this->request->post()) && $model->validate()) {

         if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
            return $this->redirect(['quotation/view', 'id' => $quotation->id]);
         }

         Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
      }

      return $this->render('create_form_job', [
         'quotation' => $quotation,
         'model' => $model
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws Exception
    * @throws NotFoundHttpException
    */
   public function actionUpdateFormJob($id): Response|string
   {

      $quotation = $this->findModel($id);
      $model = !empty($quotation->quotationFormJob) ? $quotation->quotationFormJob : new QuotationFormJob(['quotation_id' => $quotation->id]);

      if ($model->load($this->request->post()) && $model->validate()) {

         if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Data sesuai dengan validasi yang ditetapkan');
            return $this->redirect(['quotation/view', 'id' => $quotation->id]);
         }

         Yii::$app->session->setFlash('danger', 'Data tidak sesuai dengan validasi yang ditetapkan');
      }

      return $this->render('update_form_job', [
         'quotation' => $quotation,
         'model' => $model
      ]);
   }

   /**
    * @param $id
    * @return Response
    */
   public function actionDeleteFormJob($id): Response
   {

      $models = QuotationFormJob::findAll([
         'quotation_id' => $id
      ]);

      array_walk($models, function ($item) {
         $item->delete();
      });

      Yii::$app->session->setFlash('success', [[
         'title' => 'Pesan Sistem',
         'message' => 'Sukses menghapus form job ' . Quotation::findOne($id)->nomor,
      ]]);

      return $this->redirect(['quotation/view', 'id' => $id]);
   }

   /**
    * @param $id
    * @return string
    * @throws NotFoundHttpException
    */
   public function actionPrintFormJob($id): string
   {
      $quotation = $this->findModel($id);

      $this->layout = 'print';
      return $this->render('preview_print_form_job', [
         'quotation' => $quotation,
         'quotationFormJob' => $quotation->quotationFormJob
      ]);
   }

   /**
    * Create Delivery Receipt, dimana Delivery Receipt Detail by default dibentuk dari Quotation Barang
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionCreateDeliveryReceipt($id): Response|string
   {

      $quotationBarangs = QuotationBarang::find()->forCreateDeliveryReceipt($id);

      if (!$quotationBarangs) {
         Yii::$app->session->setFlash('danger', [[
            'title' => 'Pesan Sistem',
            'message' => 'Tidak dapat membuat Delivery Receipt. Sistem mendeteksi masing-masing quantity barang sudah dikirim semua.'
         ]]);
         return $this->redirect(['quotation/view', 'id' => $id]);
      }

      $component = Yii::createObject([
         'class' => DeliveryReceiptQuotation::class,
         'quotationId' => $id,
         'quotationBarangs' => $quotationBarangs,
         'scenario' => QuotationDeliveryReceipt::SCENARIO_CREATE
      ]);

      if ($this->request->isPost && $component->quotationDeliveryReceipt->load($this->request->post())) {
         if ($component->create()) {
            return $this->redirect(['quotation/view', 'id' => $id]);
         }
      }

      return $this->render('create_delivery_receipt', [
         'quotation' => $component->quotation,
         'model' => $component->quotationDeliveryReceipt,
         'modelsDetail' => $component->quotationDeliveryReceiptDetails,
      ]);
   }

   /**
    * Update Delivery Receipt
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws ServerErrorHttpException
    */
   public function actionUpdateDeliveryReceipt($id): Response|string
   {
      $component = Yii::createObject([
         'class' => DeliveryReceiptQuotation::class,
         'quotationDeliveryReceiptId' => $id,
         'scenario' => QuotationDeliveryReceipt::SCENARIO_UPDATE
      ]);

      if ($this->request->isPost && $component->quotationDeliveryReceipt->load($this->request->post())) {
         if ($component->update()) {
            return $this->redirect(['quotation/view', 'id' => $component->quotation->id]);
         }
      }

      return $this->render('update_delivery_receipt', [
         'quotation' => $component->quotation,
         'model' => $component->quotationDeliveryReceipt,
         'modelsDetail' => $component->quotationDeliveryReceiptDetails,
      ]);
   }

   /**
    * Delete Delivery Receipt
    * @param $id
    * @return Response
    * @throws InvalidConfigException
    * @throws StaleObjectException
    * @throws Throwable
    */
   public function actionDeleteDeliveryReceipt($id): Response
   {
      $component = Yii::createObject([
         'class' => DeliveryReceiptQuotation::class,
         'quotationDeliveryReceiptId' => $id
      ]);
      $component->delete();
      return $this->redirect(['quotation/view', 'id' => $component->quotationDeliveryReceipt->quotation_id]);
   }

   /**
    * Delete Delivery Receipts
    * @param $id
    * @return Response
    * @throws Throwable
    */
   public function actionDeleteAllDeliveryReceipt($id): Response
   {
      $component = Yii::createObject([
         'class' => DeliveryReceiptQuotation::class,
         'quotationId' => $id
      ]);
      $component->deleteAll();
      return $this->redirect(['quotation/view', 'id' => $id]);
   }

   /**
    * Print HTML Delivery Receipt
    * @param $id
    * @return string
    */
   public function actionPrintDeliveryReceipt($id): string
   {
      $model = QuotationDeliveryReceipt::findOne($id);
      $quotation = $model->quotation;

      $this->layout = 'print';
      return $this->render('preview_print_delivery_receipt', [
         'quotation' => $quotation,
         'model' => $model
      ]);
   }

   public function actionLaporanOutgoing(): Response|string
   {
      $model = new LaporanOutgoingQuotation();

      if ($model->load($this->request->post()) && $model->validate()) {
         return $this->redirect(['quotation/preview-laporan-outgoing',
               'tanggal' => $model->tanggal]
         );
      }

      return $this->render('_form_laporan_outgoing', [
         'model' => $model
      ]);

   }

   public function actionPreviewLaporanOutgoing($tanggal): string
   {
      $model = new LaporanOutgoingQuotation([
         'tanggal' => $tanggal
      ]);
      return $this->render('_preview_laporan_outgoing', [
         'model' => $model
      ]);
   }

}