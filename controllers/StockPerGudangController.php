<?php

namespace app\controllers;

use app\components\WizardStockPerGudangBarangKeluarDariDeliveryReceiptForm;
use app\components\WizardStockPerGudangBarangMasukDariClaimPettyCashForm;
use app\components\WizardStockPerGudangBarangMasukDariTandaTerimaPoForm;
use app\models\Barang;
use app\models\Card;
use app\models\ClaimPettyCash;
use app\models\form\ReportStockPerGudangBarangMasukDariTandaTerima;
use app\models\form\StockPerGudangBarangKeluarDariDeliveryReceiptForm;
use app\models\form\StockPerGudangBarangMasukDariClaimPettyCashForm;
use app\models\form\StockPerGudangBarangMasukDariTandaTerimaPoForm;
use app\models\form\StockPerGudangStartLocation;
use app\models\form\StockPerGudangTransferBarangAntarGudang;
use app\models\form\StockPerGudangTransferBarangAntarGudangDetail;
use app\models\HistoryLokasiBarang;
use app\models\QuotationDeliveryReceipt;
use app\models\search\HistoryLokasiBarangSearchPerCardWarehouseSearch;
use app\models\search\StockPerGudangByCardSearch;
use app\models\search\StockPerGudangPerCardPerBarangSearch;
use app\models\search\StockPerGudangSearch;
use app\models\Tabular;
use app\models\TandaTerimaBarang;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class StockPerGudangController extends Controller
{


   /**
    * @return string
    */
   public function actionIndex(): string
   {
      $searchModel = new StockPerGudangSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->pagination = false;

      return $this->render('index', [
         'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * @param $id
    * @return string
    * @throws NotFoundHttpException
    */
   public function actionViewPerCard($id): string
   {
      $searchModel = new StockPerGudangByCardSearch([
         'card' => $this->findModel($id)
      ]);
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('view', [
         'card' => $searchModel->card,
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider
      ]);

   }

   /*
    * @TODO berikan display posisi terakhir barang per card gudang
    * */
   public function actionViewPerCardPerBarang($cardId, $barangId)
   {
      $searchModel = new StockPerGudangPerCardPerBarangSearch([
         'card' => $this->findModel($cardId),
         'barang' => Barang::findOne($barangId)
      ]);
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('view_per_card_per_barang', [
         'card' => $searchModel->card,
         'barang' => $searchModel->barang,
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider
      ]);
   }

   /**
    * @throws NotFoundHttpException
    */
   protected function findModel($id): ?Card
   {
      if (($model = Card::findOne($id)) !== null) {
         return $model;
      }
      throw new NotFoundHttpException('The requested page does not exist.');
   }


   /**
    * @param $id
    * @return string
    * @throws NotFoundHttpException
    */
   public function actionViewHistoryLokasiBarangPerCard($id): string
   {
      $searchModel = new HistoryLokasiBarangSearchPerCardWarehouseSearch([
         'card' => $this->findModel($id)
      ]);
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('view_history_lokasi_barang_per_card', [
         'card' => $searchModel->card,
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider
      ]);
   }

   # Barang masuk dari start project #########################################################################################################################################

   /**
    * @return Response|string
    * @throws ServerErrorHttpException
    */
   public function actionStartLocation(): Response|string
   {
      $model = new StockPerGudangStartLocation();

      if ($this->request->isPost && $model->load($this->request->post()) && $model->validate()) :
         if ($model->save()) {
            if ($this->request->post('Continue')) {
               return $this->redirect(['stock-per-gudang/start-location']);
            }
            return $this->redirect(['stock-per-gudang/index']);
         }
      endif;

      return $this->render('_form_start_location', [
         'model' => $model
      ]);
   }

   # Barang masuk dari tanda terima purchase order #########################################################################################################################################

   /**
    * @return Response|string
    * @throws InvalidConfigException
    */
   public function actionBarangMasukTandaTerimaPoStep1(): Response|string
   {
      # Create component dengan rule step 1
      $component = Yii::createObject([
         'class' => WizardStockPerGudangBarangMasukDariTandaTerimaPoForm::class,
         'model' => (new StockPerGudangBarangMasukDariTandaTerimaPoForm([
            'scenario' => StockPerGudangBarangMasukDariTandaTerimaPoForm::SCENARIO_STEP_1
         ])),
      ]);

      # POST dan validate
      if ($component->model->load($this->request->post()) && $component->model->validate())
         return $this->redirect([
            'stock-per-gudang/barang-masuk-tanda-terima-po-step2',
            'id' => $component->model->nomorTandaTerimaId
         ]);

      # GET | Default render
      return $this->render('_form_barang_masuk_tanda_terima_po_step_1', [
         'model' => $component->model
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws NotFoundHttpException
    * @throws ServerErrorHttpException
    * @throws InvalidConfigException
    */
   public function actionBarangMasukTandaTerimaPoStep2($id): Response|string
   {
      # Find tanda terima barang di database
      $tandaTerimaBarang = $this->findTandaTerimaBarangHistoryLokasiBarangs($id);

      # Cek tanda terima barang belum masuk di history lokasi barang
      if (!$this->checkTandaTerimaBarangSudahPernahMasukKeHistoryLocation($tandaTerimaBarang))
         return $this->redirect(!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : ['/']);

      # Create component dengan rule step 2
      $component = Yii::createObject([
         'class' => WizardStockPerGudangBarangMasukDariTandaTerimaPoForm::class,
         'model' => (new StockPerGudangBarangMasukDariTandaTerimaPoForm([
            'scenario' => StockPerGudangBarangMasukDariTandaTerimaPoForm::SCENARIO_STEP_2,
            'tandaTerimaBarang' => $tandaTerimaBarang,
            'nomorTandaTerimaId' => $id,
         ])),
      ]);

      # POST & save
      if ($this->request->isPost) {
         if ($component->save()) return $this->redirect(['stock-per-gudang/index']);
      }

      # Default render | GET
      return $this->render('_form_barang_masuk_tanda_terima_po_step_2', [
         'model' => $component->model,
         'modelsDetail' => $component->modelsDetail,
         'modelsDetailDetail' => empty($component->modelsDetailDetail)
            ? [[new HistoryLokasiBarang()]]
            : $component->modelsDetailDetail,
      ]);
   }

   /**
    * @param $id
    * @return TandaTerimaBarang
    * @throws NotFoundHttpException
    */
   protected function findTandaTerimaBarangHistoryLokasiBarangs($id): TandaTerimaBarang
   {
      if (($model = TandaTerimaBarang::findOne($id)) !== null) {
         return $model;
      }
      throw new NotFoundHttpException('Tanda terima barang tidak ditemukan dengan id: ' . $id);
   }

   /**
    * @param TandaTerimaBarang $tandaTerimaBarang
    * @return bool
    */
   protected function checkTandaTerimaBarangSudahPernahMasukKeHistoryLocation(TandaTerimaBarang $tandaTerimaBarang): bool
   {
      if (!$tandaTerimaBarang->historyLokasiBarangs) return true;
      Yii::$app->session->setFlash('error', [[
         'title' => 'Gagal',
         'message' => $tandaTerimaBarang->nomor . ' sudah pernah terdaftar di pencatatan lokasi'
      ]]);
      return false;
   }

   # Barang masuk dari claim petty cash #########################################################################################################################################

   /**
    * @return Response|string
    * @throws InvalidConfigException
    */
   public function actionBarangMasukClaimPettyCashStep1(): Response|string
   {
      # Component step 1
      $component = Yii::createObject([
         'class' => WizardStockPerGudangBarangMasukDariClaimPettyCashForm::class,
         'model' => (new StockPerGudangBarangMasukDariClaimPettyCashForm([
            'scenario' => StockPerGudangBarangMasukDariClaimPettyCashForm::SCENARIO_STEP_1
         ]))
      ]);

      # POST dan validate
      if ($component->model->load($this->request->post()) && $component->model->validate()) {
         return $this->redirect([
            'stock-per-gudang/barang-masuk-claim-petty-cash-step2',
            'id' => $component->model->nomorClaimPettyCashId
         ]);
      }

      # GET | render
      return $this->render('_form_barang_masuk_claim_petty_cash_step_1', [
         'model' => $component->model
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws ServerErrorHttpException
    * @throws NotFoundHttpException
    */
   public function actionBarangMasukClaimPettyCashStep2($id): Response|string
   {

      # Find claim petty cash di database
      $claimPettyCash = $this->findClaimPettyCash($id);

      # Cek claim petty cash belum masuk di history lokasi barang
      if (!$this->checkClaimPettyCashSudahPernahMasukKeHistoryLocation($claimPettyCash)) {
         return $this->redirect(!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : ['/']);
      }

      # Create component dengan rule 2
      $component = Yii::createObject([
         'class' => WizardStockPerGudangBarangMasukDariClaimPettyCashForm::class,
         'model' => (new StockPerGudangBarangMasukDariClaimPettyCashForm([
            'claimPettyCash' => $claimPettyCash,
            'nomorClaimPettyCashId' => $id,
            'scenario' => StockPerGudangBarangMasukDariClaimPettyCashForm::SCENARIO_STEP_2,
         ]))
      ]);

      # POST and save
      if ($this->request->isPost) {
         if ($component->save()) return $this->redirect(['stock-per-gudang/index']);
      }

      # Default GET
      return $this->render('_form_barang_masuk_claim_petty_cash_step_2', [
         'model' => $component->model,
         'modelsDetail' => $component->modelsDetail,
         'modelsDetailDetail' => empty($component->modelsDetailDetail)
            ? [[new HistoryLokasiBarang()]]
            : $component->modelsDetailDetail,
      ]);
   }

   /**
    * @param $id
    * @return ClaimPettyCash
    * @throws NotFoundHttpException
    */
   protected function findClaimPettyCash($id): ClaimPettyCash
   {
      if (($model = ClaimPettyCash::findOne($id)) !== null) {
         return $model;
      }
      throw new NotFoundHttpException('Claim Petty Cash tidak ditemukan dengan id: ' . $id);
   }

   /**
    * @param ClaimPettyCash $claimPettyCash
    * @return bool
    */
   protected function checkClaimPettyCashSudahPernahMasukKeHistoryLocation(ClaimPettyCash $claimPettyCash): bool
   {
      if (!$claimPettyCash->historyLokasiBarangs) {
         return true;
      }
      Yii::$app->session->setFlash('error', [[
         'title' => 'Gagal',
         'message' => $claimPettyCash->nomor . ' sudah pernah terdaftar di pencatatan lokasi'
      ]]);
      return false;
   }

   # Barang keluar dari delivery receipt ##########################################################################################################################################

   /**
    * @return Response|string
    * @throws InvalidConfigException
    */
   public function actionBarangKeluarDeliveryReceiptStep1(): Response|string
   {
      # Component Step 2
      $component = Yii::createObject([
         'class' => WizardStockPerGudangBarangKeluarDariDeliveryReceiptForm::class,
         'model' => new StockPerGudangBarangKeluarDariDeliveryReceiptForm([
            'scenario' => StockPerGudangBarangKeluarDariDeliveryReceiptForm::SCENARIO_STEP_1
         ])
      ]);

      # POST and validate
      if ($component->model->load($this->request->post()) && $component->model->validate()) {
         return $this->redirect([
            'stock-per-gudang/barang-keluar-delivery-receipt-step2',
            'id' => $component->model->nomorDeliveryReceiptId
         ]);
      }

      # Get | Default render
      return $this->render('_form_barang_keluar_delivery_receipt_step_1', [
         'model' => $component->model
      ]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws InvalidConfigException
    * @throws NotFoundHttpException
    * @throws ServerErrorHttpException
    */
   public function actionBarangKeluarDeliveryReceiptStep2($id): Response|string
   {
      $quotationDeliveryReceipt = $this->findQuotationDeliveryReceiptHistoryLokasiBarangs($id);

      # Cek claim petty cash belum masuk di history lokasi barang
      if (!$this->checkQuotationDeliveryReceiptSudahPernahMasukKeHistoryLocation($quotationDeliveryReceipt)) {
         return $this->redirect(!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : ['/']);
      }

      # Component step 2
      $component = Yii::createObject([
         'class' => WizardStockPerGudangBarangKeluarDariDeliveryReceiptForm::class,
         'model' => (new StockPerGudangBarangKeluarDariDeliveryReceiptForm([
            'quotationDeliveryReceipt' => $quotationDeliveryReceipt,
            'scenario' => StockPerGudangBarangKeluarDariDeliveryReceiptForm::SCENARIO_STEP_2
         ]))
      ]);

      # POST and save
      if ($this->request->isPost) {
         if ($component->save()) return $this->redirect(['stock-per-gudang/index']);
      }

      # GET | Default
      return $this->render('_form_barang_keluar_delivery_receipt_step_2', [
         'model' => $component->model,
         'modelsDetail' => $component->modelsDetail,
         'modelsDetailDetail' => empty($component->modelsDetailDetail)
            ? [[new HistoryLokasiBarang()]]
            : $component->modelsDetailDetail,
      ]);
   }

   /**
    * @param $id
    * @return QuotationDeliveryReceipt|Response
    * @throws NotFoundHttpException
    */
   protected function findQuotationDeliveryReceiptHistoryLokasiBarangs($id): QuotationDeliveryReceipt|Response
   {
      if (($model = QuotationDeliveryReceipt::findOne($id)) !== null) {
         return $model;
      }
      throw new NotFoundHttpException('Quotation Delivery Receipt tidak ditemukan dengan id: ' . $id);
   }

   /**
    * @param QuotationDeliveryReceipt $quotationDeliveryReceipt
    * @return bool
    */
   protected function checkQuotationDeliveryReceiptSudahPernahMasukKeHistoryLocation(QuotationDeliveryReceipt $quotationDeliveryReceipt)
   {
      if (!$quotationDeliveryReceipt->historyLokasiBarangs) {
         return true;
      }
      Yii::$app->session->setFlash('error', [[
         'title' => 'Gagal',
         'message' => $quotationDeliveryReceipt->nomor . ' sudah pernah terdaftar di pencatatan lokasi'
      ]]);

      return false;

   }

   # Transfer barang | Satu Gudang | Antar Gudang ##########################################################################################################################################

   /**
    * @return Response|string
    * @throws ServerErrorHttpException
    */
   public function actionTransferBarangAntarGudang(): Response|string
   {
      $model = new StockPerGudangTransferBarangAntarGudang();
      $modelsDetail = [new StockPerGudangTransferBarangAntarGudangDetail()];

      if ($this->request->isPost && $model->load($this->request->post())) {

         $modelsDetail = Tabular::createMultiple(
            StockPerGudangTransferBarangAntarGudangDetail::class
         );
         Tabular::loadMultiple(
            $modelsDetail,
            $this->request->post());
         $model->modelsDetail = $modelsDetail;

         if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {
            if ($model->save()) return $this->redirect(['stock-per-gudang/index']);
         }

      }

      return $this->render('_form_transfer_barang_antar_gudang', [
         'model' => $model,
         'modelsDetail' => $modelsDetail,
      ]);

   }

   ###########################################################################################################################################

   /**
    * @param $q
    * @param $id
    * @return array[]
    */
   #[ArrayShape(['results' => "mixed|string[]"])]
   public function actionFindClaimPettyCash($q = null, $id = null): array
   {
      Yii::$app->response->format = Response::FORMAT_JSON;
      $out = ['results' => ['id' => '', 'text' => '']];

      if (!is_null($q)) {

         $data = ClaimPettyCash::find()->byNomor($q);
         $out['results'] = array_values($data);
      } elseif ($id > 0) {

         $out['results'] = [
            'id' => $id,
            'text' => ClaimPettyCash::findOne($id)->nomor
         ];
      }

      return $out;
   }

   /**
    * @param $q
    * @param $id
    * @return array[]
    */
   #[ArrayShape(['results' => "mixed|string[]"])]
   public function actionFindTandaTerimaBarang($q = null, $id = null): array
   {
      Yii::$app->response->format = Response::FORMAT_JSON;
      $out = ['results' => ['id' => '', 'text' => '']];

      if (!is_null($q)) {

         $data = TandaTerimaBarang::find()->byNomor($q);
         $out['results'] = array_values($data);

      } elseif ($id > 0) {

         $out['results'] = [
            'id' => $id,
            'text' => TandaTerimaBarang::findOne($id)->nomor
         ];

      }

      return $out;
   }

   /**
    * @param string $modelName
    * @return string
    */
   public function actionCreateReportBarangMasuk(string $modelName): string
   {
      $model = new ReportStockPerGudangBarangMasukDariTandaTerima();
      $model->classNameModel = 'app\\models\\' . $modelName;

      $urlFind = $modelName == StringHelper::basename(TandaTerimaBarang::class)
         ? Url::to(['/stock-per-gudang/find-tanda-terima-barang'])
         : Url::to(['/stock-per-gudang/find-claim-petty-cash']);

      $pagePrint = $modelName == StringHelper::basename(TandaTerimaBarang::class)
         ? 'print_barang_masuk_tanda_terima_barang'
         : 'print_barang_masuk_claim_petty_cash';

      $initValueText = $urlPrint = '';
      if ($this->request->isPost && $model->load($this->request->post())) {

         $modelReporting = $model->getModel();
         $initValueText = $modelReporting->nomor;

         $urlPrint = $modelReporting instanceof TandaTerimaBarang
            ? ['stock-per-gudang/print-barang-masuk-tanda-terima-po', 'id' => $modelReporting->id]
            : ['stock-per-gudang/print-barang-masuk-claim-petty-cash', 'id' => $modelReporting->id];

      }

      return $this->render('_form_report_barang_masuk_dari_tanda_terima', [
         'model' => $model,
         'initValueText' => $initValueText,
         'urlPrint' => $urlPrint,
         'urlFind' => $urlFind,
         'pagePrint' => $pagePrint
      ]);
   }

   /**
    * @param $id
    * @return string
    */
   public function actionPrintBarangMasukTandaTerimaPo($id): string
   {
      $this->layout = 'print';
      return $this->render('print_barang_masuk_tanda_terima_barang', [
         'model' => TandaTerimaBarang::findOne($id)
      ]);
   }

   /**
    * @param $id
    * @return string
    */
   public function actionPrintBarangMasukClaimPettyCash($id): string
   {
      $this->layout = 'print';
      return $this->render('print_barang_masuk_claim_petty_cash', [
         'model' => ClaimPettyCash::findOne($id)
      ]);
   }

}