<?php

namespace app\controllers;

use app\enums\TextLinkEnum;
use app\models\form\BeforeCreatePurchaseOrderForm;
use app\models\MaterialRequisition;
use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use app\models\PurchaseOrder;
use app\models\search\PurchaseOrderSearch;
use app\models\Tabular;
use JetBrains\PhpStorm\ArrayShape;
use Throwable;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * PurchaseOrderController implements the CRUD actions for PurchaseOrder model.
 */
class PurchaseOrderController extends Controller
{
   /**
    * @inheritdoc
    */
   #[ArrayShape(['verbs' => "array"])]
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
    * Lists all PurchaseOrder models.
    * @return string
    */
   public function actionIndex(): string
   {
      $searchModel = new PurchaseOrderSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * Displays a single PurchaseOrder model.
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
    * Finds the PurchaseOrder model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return PurchaseOrder the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
   protected function findModel(int $id): PurchaseOrder
   {
      if (($model = PurchaseOrder::findOne($id)) !== null) {
         return $model;
      } else {
         throw new NotFoundHttpException('The requested page does not exist.');
      }
   }

   /**
    * Langkah pertama dalam membuat purchase order
    * @return Response|string
    */
   public function actionBeforeCreate(): Response|string
   {
      $model = new BeforeCreatePurchaseOrderForm();

      if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->validate()) {
         // Url::remember();
         return $this->redirect(['purchase-order/create',
            'materialRequestAndVendorId' => $model->nomorMaterialRequest
         ]);
      }

      return $this->render('before_create', [
         'model' => $model
      ]);
   }

   /**
    * @param $q
    * @param $id
    * @return string[][]
    */
   #[ArrayShape(['results' => "mixed|string[]"])]
   public function actionFindMrForCreatePo($q = null, $id = null): array
   {
      Yii::$app->response->format = Response::FORMAT_JSON;
      $out = ['results' => ['id' => '', 'text' => '']];

      if (!is_null($q)) {

         $data = MaterialRequisitionDetail::find()->beforeCreatePurchaseOrder($q);
         $out['results'] = array_values($data);

      } elseif ($id > 0) {

         $out['results'] = [
            'id' => $id,
            'text' => MaterialRequisition::find($id)->nomor
         ];

      }

      return $out;
   }

   /**
    * Creates a new PurchaseOrder model.
    * @param $materialRequestAndVendorId
    * @return string|Response
    */
   public function actionCreate($materialRequestAndVendorId): Response|string
   {

      /*if (!$this->checkUrlCreate()) {
          return $this->redirect(['purchase-order/before-create']);
      }*/

      $materialRequestAndVendorId = Json::decode($materialRequestAndVendorId);
      $model = new PurchaseOrder();
      $modelsDetail = MaterialRequisitionDetailPenawaran::find()->forCreateAction($materialRequestAndVendorId);

      if ($model->load($this->request->post())) {

         $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetailPenawaran::class, $modelsDetail);
         Tabular::loadMultiple($modelsDetail, $this->request->post());

         if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {

            $status = $model->createWithDetails($modelsDetail);

            if ($status['code']) {
               Url::remember(); // reset url dari before-create ke create

               Yii::$app->session->setFlash('success', [[
                  'title' => 'Sukses membuat sebuah Purchase Order',
                  'message' => 'Purchase Order: ' . Html::tag('strong', $model->nomor) . " berhasil ditambahkan.",
                  'footer' =>
                     Html::a(TextLinkEnum::PRINT->value, ['purchase-order/print', 'id' => $model->id], [
                        'class' => 'btn btn-success',
                        'target' => '_blank',
                        'rel' => 'noopener noreferrer'
                     ])
               ]]);
               return $this->redirect(['purchase-order/view', 'id' => $model->id]);
            }

            Yii::$app->session->setFlash('danger', " Purchase Order is failed to insert. Info: " . $status['message']);
         }
      }

      return $this->render('create', [
         'model' => $model,
         'modelsDetail' => empty($modelsDetail) ? [new MaterialRequisitionDetailPenawaran()] : $modelsDetail,
      ]);
   }

   /**
    * Updates an existing PurchaseOrder model.
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
      $modelsDetail = !empty($model->materialRequisitionDetailPenawarans)
         ? $model->materialRequisitionDetailPenawarans
         : [new MaterialRequisitionDetailPenawaran()];

      if ($model->load($request->post())) {

         $oldDetailsID = ArrayHelper::map($modelsDetail, 'id', 'id');
         $modelsDetail = Tabular::createMultiple(MaterialRequisitionDetailPenawaran::class, $modelsDetail);

         Tabular::loadMultiple($modelsDetail, $request->post());
         $deletedDetailsID = array_diff($oldDetailsID, array_filter(ArrayHelper::map($modelsDetail, 'id', 'id')));

         if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {

            $status = $model->updateWithDetails($modelsDetail, $deletedDetailsID);

            if ($status['code']) {
               Yii::$app->session->setFlash('info', "PurchaseOrder: " . Html::a($model->nomor, ['view', 'id' => $model->id]) . " berhasil di update.");
               return $this->redirect(['purchase-order/view', 'id' => $id]);
            }

            Yii::$app->session->setFlash('danger', " PurchaseOrder is failed to updated. Info: " . $status['message']);
         }
      }

      return $this->render('update', [
         'model' => $model,
         'modelsDetail' => $modelsDetail
      ]);
   }

   /**
    * Delete an existing PurchaseOrder model.
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

      if ($model->tandaTerimaBarangs) {
         Yii::$app->session->setFlash('danger', " Purchase Order : " . $model->nomor . " tidak bisa dihapus, karena Tanda Terima strong dependant dengan " .
            $model->nomorTandaTerimaColumnsAsHtml
         );
         return $this->redirect(Yii::$app->request->referrer);
      }

      $model->delete();

      Yii::$app->session->setFlash('success', " PurchaseOrder : " . $model->nomor . " berhasil dihapus.");
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
    * @return string
    * @throws NotFoundHttpException
    */
   public function actionExpandItem(): string
   {
      if (isset($_POST['expandRowKey'])) {
         return $this->renderPartial('_item', [
            'model' => $this->findModel($_POST['expandRowKey'])
         ]);
      } else {
         return '<div class="alert alert-danger">No data found</div>';
      }
   }

   /**
    * @return bool
    */
   protected function checkUrlCreate(): bool
   {
      $allowedUrl = ['/purchase-order/before-create'];
      if (!in_array(Url::previous(), $allowedUrl)) {
         return false;
      }
      return true;
   }

}