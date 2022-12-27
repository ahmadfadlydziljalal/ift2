<?php

namespace app\controllers;

use app\components\helpers\ArrayHelper;
use app\enums\TextLinkEnum;
use app\models\Card;
use app\models\ClaimPettyCash;
use app\models\ClaimPettyCashNotaDetail;
use app\models\form\ReportStockPerGudangBarangMasukDariTandaTerima;
use app\models\form\StockPerGudangBarangKeluarDariDeliveryReceiptForm;
use app\models\form\StockPerGudangBarangMasukDariClaimPettyCashForm;
use app\models\form\StockPerGudangBarangMasukDariTandaTerimaPoForm;
use app\models\form\StockPerGudangTransferBarangAntarGudang;
use app\models\form\StockPerGudangTransferBarangAntarGudangDetail;
use app\models\HistoryLokasiBarang;
use app\models\QuotationDeliveryReceipt;
use app\models\QuotationDeliveryReceiptDetail;
use app\models\search\LokasiBarangPerCardSearch;
use app\models\search\LokasiBarangSearch;
use app\models\Status;
use app\models\Tabular;
use app\models\TandaTerimaBarang;
use app\models\TandaTerimaBarangDetail;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\helpers\Html;
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
      $searchModel = new LokasiBarangSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->pagination = false;

      return $this->render('index', [
         'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * @throws NotFoundHttpException
    */
   public function actionView($id): string
   {
      $card = $this->findModel($id);
      $searchModel = new LokasiBarangPerCardSearch([
         'card' => $card
      ]);

      return $this->render('view', [
         'card' => $card,
         'searchModel' => $searchModel,
         'dataProvider' => $searchModel->search(Yii::$app->request->queryParams)
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
    * @return Response|string
    */
   public function actionBarangMasukTandaTerimaPoStep1(): Response|string
   {
      $model = new StockPerGudangBarangMasukDariTandaTerimaPoForm();
      $model->scenario = $model::SCENARIO_STEP_1;

      if ($model->load($this->request->post()) && $model->validate()) {
         return $this->redirect(['stock-per-gudang/barang-masuk-tanda-terima-po-step2', 'id' => $model->nomorTandaTerimaId]);
      }

      return $this->render('_form_barang_masuk_tanda_terima_po_step_1', ['model' => $model]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws ServerErrorHttpException
    */
   public function actionBarangMasukTandaTerimaPoStep2($id): Response|string
   {

      $tandaTerimaBarang = $this->findTandaTerimaBarangHistoryLokasiBarangs($id);

      $model = new StockPerGudangBarangMasukDariTandaTerimaPoForm([
         'tandaTerimaBarang' => $tandaTerimaBarang,
         'nomorTandaTerimaId' => $id,
         'scenario' => StockPerGudangBarangMasukDariTandaTerimaPoForm::SCENARIO_STEP_2
      ]);
      $modelsDetail = $tandaTerimaBarang->tandaTerimaBarangDetails;
      $modelsDetailDetail = [];
      foreach ($modelsDetail as $i => $detail) {
         $modelsDetailDetail[$i][] = new HistoryLokasiBarang([
            'tanda_terima_barang_detail_id' => $detail->id,
         ]);
      }

      if ($this->request->isPost) {

         $modelsDetail = Tabular::createMultiple(
            TandaTerimaBarangDetail::class,
            $modelsDetail
         );
         Tabular::loadMultiple($modelsDetail, $this->request->post());
         $model->tandaTerimaBarangDetails = $modelsDetail;

         $isValid = true;
         if (isset($_POST['HistoryLokasiBarang'][0][0])) {

            foreach ($_POST['HistoryLokasiBarang'] as $i => $historyLokasiBarangs) {
               foreach ($historyLokasiBarangs as $j => $historyLokasiBarang) {
                  $data['HistoryLokasiBarang'] = $historyLokasiBarang;

                  $modelHistoryLokasiBarang = new HistoryLokasiBarang();
                  $modelHistoryLokasiBarang->load($data);
                  $modelHistoryLokasiBarang->tipe_pergerakan_id = Status::findOne([
                     'section' => Status::SECTION_SET_LOKASI_BARANG,
                     'key' => 'in'
                  ])->id;
                  $modelHistoryLokasiBarang->step = 0;

                  $modelsDetailDetail[$i][$j] = $modelHistoryLokasiBarang;
                  $isValid = $modelHistoryLokasiBarang->validate() && $isValid;
               }
            }

            /** @var TandaTerimaBarangDetail $item */
            foreach ($modelsDetail as $indexDetail => $item) {
               $item->scenario = TandaTerimaBarangDetail::SCENARIO_INPUT_KE_GUDANG;
               $item->totalQuantityTerimaPerbandiganLokasi = array_sum(
                  ArrayHelper::getColumn($modelsDetailDetail[$indexDetail], 'quantity')
               );
            }
         }

         $model->historyLokasiBarangs = $modelsDetailDetail;

         $isValid = $model->validate() && $isValid;
         $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

         if ($isValid) {
            if ($model->save()) {
               Yii::$app->session->setFlash('success', [[
                  'title' => 'Lokasi in berhasil di record.',
                  'message' => 'Lokasi tanda terima berhasil disimpan dengan nomor referensi ' .
                     Html::tag('span', $model->getNomorHistoryLokasiBarang(), ['class' => 'badge bg-primary']),
                  'footer' => Html::a(TextLinkEnum::PRINT->value,
                     ['stock-per-gudang/print-barang-masuk-tanda-terima-po', 'id' => $id],
                     [
                        'target' => '_blank',
                        'class' => 'btn btn-primary'
                     ]
                  )
               ]]);
               return $this->redirect(['stock-per-gudang/index']);
            }
         }

         Yii::$app->session->setFlash('error', [['title' => 'Gagal', 'message' => 'Please check again ...!']]);
      }

      return $this->render('_form_barang_masuk_tanda_terima_po_step_2', [
         'model' => $model,
         'modelsDetail' => $modelsDetail,
         'modelsDetailDetail' => empty($modelsDetailDetail)
            ? [[new HistoryLokasiBarang()]]
            : $modelsDetailDetail,
      ]);
   }

   /**
    * @param $id
    * @return TandaTerimaBarang|Response
    * @throws NotFoundHttpException
    */
   protected function findTandaTerimaBarangHistoryLokasiBarangs($id)
   {
      $tandaTerimaBarang = TandaTerimaBarang::findOne($id);

      if (!$tandaTerimaBarang) throw new NotFoundHttpException('Tanda terima barang tidak ditemukan dengan id: ' . $id);

      if ($tandaTerimaBarang->historyLokasiBarangs) {
         Yii::$app->session->setFlash('error', [[
            'title' => 'Gagal',
            'message' => $tandaTerimaBarang->nomor . ' sudah pernah terdaftar di pencatatan lokasi'
         ]]);
         return $this->redirect(!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : ['/']);
      }

      return $tandaTerimaBarang;
   }

   /**
    * @return Response|string
    */
   public function actionBarangMasukClaimPettyCashStep1(): Response|string
   {
      $model = new StockPerGudangBarangMasukDariClaimPettyCashForm();
      $model->scenario = $model::SCENARIO_STEP_1;

      if ($model->load($this->request->post()) && $model->validate()) {
         return $this->redirect(['stock-per-gudang/barang-masuk-claim-petty-cash-step2', 'id' => $model->nomorClaimPettyCashId]);
      }

      return $this->render('_form_barang_masuk_claim_petty_cash_step_1', ['model' => $model]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws ServerErrorHttpException
    * @throws NotFoundHttpException
    */
   public function actionBarangMasukClaimPettyCashStep2($id): Response|string
   {

      $claimPettyCash = $this->findClaimPettyCashHistoryLokasiBarangs($id);

      $model = new StockPerGudangBarangMasukDariClaimPettyCashForm([
         'claimPettyCash' => $claimPettyCash,
         'nomorClaimPettyCashId' => $id,
         'scenario' => StockPerGudangBarangMasukDariClaimPettyCashForm::SCENARIO_STEP_2,
      ]);

      $modelsDetail = $claimPettyCash->claimPettyCashNotaDetailsHaveStockType;

      $modelsDetailDetail = [];
      foreach ($modelsDetail as $i => $detail) {
         $modelsDetailDetail[$i][] = new HistoryLokasiBarang([
            'claim_petty_cash_nota_detail_id' => $detail->id,
         ]);
      }

      if ($this->request->isPost) {

         $modelsDetail = Tabular::createMultiple(ClaimPettyCashNotaDetail::class, $modelsDetail);

         Tabular::loadMultiple($modelsDetail, $this->request->post());
         $model->claimPettyCashNotaDetails = $modelsDetail;

         $isValid = true;
         if (isset($_POST['HistoryLokasiBarang'][0][0])) {

            foreach ($_POST['HistoryLokasiBarang'] as $i => $historyLokasiBarangs) {
               foreach ($historyLokasiBarangs as $j => $historyLokasiBarang) {
                  $data['HistoryLokasiBarang'] = $historyLokasiBarang;

                  $modelHistoryLokasiBarang = new HistoryLokasiBarang();
                  $modelHistoryLokasiBarang->load($data);

                  $modelHistoryLokasiBarang->tipe_pergerakan_id = Status::findOne([
                     'section' => Status::SECTION_SET_LOKASI_BARANG,
                     'key' => 'in'
                  ])->id;

                  $modelHistoryLokasiBarang->step = 0;

                  $modelsDetailDetail[$i][$j] = $modelHistoryLokasiBarang;
                  $isValid = $modelHistoryLokasiBarang->validate() && $isValid;
               }
            }

            /** @var ClaimPettyCashNotaDetail $item */
            foreach ($modelsDetail as $indexDetail => $item) {
               $item->scenario = ClaimPettyCashNotaDetail::SCENARIO_INPUT_KE_GUDANG;
               $item->totalQuantityTerimaPerbandiganLokasi = array_sum(
                  ArrayHelper::getColumn($modelsDetailDetail[$indexDetail], 'quantity')
               );
            }
         }

         $model->historyLokasiBarangs = $modelsDetailDetail;
         $isValid = $model->validate() && $isValid;
         $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

         if ($isValid) {

            if ($model->save()) {
               Yii::$app->session->setFlash('success', [[
                  'title' => 'Lokasi in berhasil di record.',
                  'message' => 'Lokasi Claim Petty Cash berhasil disimpan dengan nomor referensi ' . Html::tag('span', $model->getNomorHistoryLokasiBarang(), ['class' => 'badge bg-primary']),
                  'footer' => Html::a(
                     TextLinkEnum::PRINT->value,
                     ['stock-per-gudang/print-barang-masuk-claim-petty-cash', 'id' => $id],
                     [
                        'target' => '_blank',
                        'class' => 'btn btn-primary'
                     ]
                  )
               ]]);
               return $this->redirect(['stock-per-gudang/index']);
            }
         }

         Yii::$app->session->setFlash('error', [[
            'title' => 'Gagal',
            'message' => 'Please check again ...!'
         ]]);
      }

      return $this->render('_form_barang_masuk_claim_petty_cash_step_2', [
         'model' => $model,
         'modelsDetail' => $modelsDetail,
         'modelsDetailDetail' => empty($modelsDetailDetail)
            ? [[new HistoryLokasiBarang()]]
            : $modelsDetailDetail,
      ]);
   }

   /**
    * @param $id
    * @return ClaimPettyCash|Response
    * @throws NotFoundHttpException
    */
   protected function findClaimPettyCashHistoryLokasiBarangs($id): Response|ClaimPettyCash
   {
      $claimPettyCash = ClaimPettyCash::findOne($id);

      if (!$claimPettyCash) throw new NotFoundHttpException('Claim Petty Cash tidak ditemukan dengan id: ', $id);

      if ($claimPettyCash->historyLokasiBarangs) {

         Yii::$app->session->setFlash('error', [[
            'title' => 'Gagal',
            'message' => $claimPettyCash->nomor . ' sudah pernah terdaftar di pencatatan lokasi'
         ]]);

         return $this->redirect(
            !empty(Yii::$app->request->referrer)
               ? Yii::$app->request->referrer
               : ['/']
         );
      }

      return $claimPettyCash;
   }

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

   /**
    * @return Response|string
    * @throws ServerErrorHttpException
    */
   public function actionTransferBarangAntarGudang(): Response|string
   {

      $model = new StockPerGudangTransferBarangAntarGudang();
      $modelsDetail = [new StockPerGudangTransferBarangAntarGudangDetail()];

      if ($this->request->isPost && $model->load($this->request->post())) {

         $modelsDetail = Tabular::createMultiple(StockPerGudangTransferBarangAntarGudangDetail::class);
         Tabular::loadMultiple($modelsDetail, $this->request->post());

         $model->modelsDetail = $modelsDetail;

         if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {

            if ($model->save()) {
               Yii::$app->session->setFlash('success', [[
                  'title' => 'Pesan sukses',
                  'message' => 'Transfer berhasil dengan nomor referensi ' . Html::tag('span', $model->getNomorHistoryLokasiBarang(), ['class' => 'badge bg-primary']),
               ]]);
               return $this->redirect(['stock-per-gudang/index']);
            }

            Yii::$app->session->setFlash('danger', [[
               'title' => 'Pesan gagal',
               'message' => 'Transfer gagal.'
            ]]);
         }

      }

      return $this->render('_form_transfer_barang_antar_gudang', [
         'model' => $model,
         'modelsDetail' => $modelsDetail,
      ]);

   }

   /**
    * @return Response|string
    */
   public function actionBarangKeluarDeliveryReceiptStep1(): Response|string
   {
      $model = new StockPerGudangBarangKeluarDariDeliveryReceiptForm();
      $model->scenario = $model::SCENARIO_STEP_1;

      if ($model->load($this->request->post()) && $model->validate()) {
         return $this->redirect(['stock-per-gudang/barang-keluar-delivery-receipt-step2', 'id' => $model->nomorDeliveryReceiptId]);
      }

      return $this->render('_form_barang_keluar_delivery_receipt_step_1', ['model' => $model]);
   }

   /**
    * @param $id
    * @return Response|string
    * @throws NotFoundHttpException
    * @throws ServerErrorHttpException
    */
   public function actionBarangKeluarDeliveryReceiptStep2($id): Response|string
   {
      $quotationDeliveryReceipt = $this->findQuotationDeliveryReceiptHistoryLokasiBarangs($id);

      $model = new StockPerGudangBarangKeluarDariDeliveryReceiptForm([
         'quotationDeliveryReceipt' => $quotationDeliveryReceipt,
         'scenario' => StockPerGudangBarangKeluarDariDeliveryReceiptForm::SCENARIO_STEP_2
      ]);

      $modelsDetail = $quotationDeliveryReceipt->quotationDeliveryReceiptDetails;

      $modelsDetailDetail = [];
      foreach ($modelsDetail as $i => $detail) {
         $modelsDetailDetail[$i][] = new HistoryLokasiBarang([
            'quotation_delivery_receipt_detail_id' => $detail->id,
         ]);
      }

      if ($this->request->isPost) {

         $modelsDetail = Tabular::createMultiple(
            QuotationDeliveryReceiptDetail::class,
            $modelsDetail
         );

         Tabular::loadMultiple($modelsDetail, $this->request->post());
         $model->quotationDeliveryReceiptDetails = $modelsDetail;

         $isValid = true;
         if (isset($_POST['HistoryLokasiBarang'][0][0])) {

            foreach ($_POST['HistoryLokasiBarang'] as $i => $historyLokasiBarangs) {
               foreach ($historyLokasiBarangs as $j => $historyLokasiBarang) {
                  $data['HistoryLokasiBarang'] = $historyLokasiBarang;

                  $modelHistoryLokasiBarang = new HistoryLokasiBarang();
                  $modelHistoryLokasiBarang->load($data);

                  $modelHistoryLokasiBarang->tipe_pergerakan_id = Status::findOne([
                     'section' => Status::SECTION_SET_LOKASI_BARANG,
                     'key' => 'out'
                  ])->id;

                  $modelHistoryLokasiBarang->step = 0;

                  $modelsDetailDetail[$i][$j] = $modelHistoryLokasiBarang;
                  $isValid = $modelHistoryLokasiBarang->validate() && $isValid;
               }
            }

            /** @var QuotationDeliveryReceiptDetail $item */
            foreach ($modelsDetail as $indexDetail => $item) {
               $item->scenario = QuotationDeliveryReceiptDetail::SCENARIO_INPUT_KE_GUDANG;
               $item->totalQuantityTerimaPerbandiganLokasi = array_sum(
                  ArrayHelper::getColumn($modelsDetailDetail[$indexDetail], 'quantity')
               );
            }
         }

         $isValid = $model->validate() && $isValid;
         $isValid = Tabular::validateMultiple($modelsDetail) && $isValid;

         if ($isValid) {
            $model->historyLokasiBarangs = $modelsDetailDetail;
            if ($model->save()) {
               Yii::$app->session->setFlash('success', [[
                  'title' => 'Lokasi in berhasil di record.',
                  'message' => 'Lokasi Delivery Receipt berhasil disimpan dengan nomor referensi ' . Html::tag('span', $model->getNomorHistoryLokasiBarang(), ['class' => 'badge bg-primary']),
                  'footer' => Html::a(
                     TextLinkEnum::PRINT->value,
                     ['stock-per-gudang/print-barang-masuk-claim-petty-cash', 'id' => $id],
                     [
                        'target' => '_blank',
                        'class' => 'btn btn-primary'
                     ]
                  )
               ]]);
               return $this->redirect(['stock-per-gudang/index']);
            }
         }

         Yii::$app->session->setFlash('error', [[
            'title' => 'Gagal',
            'message' => 'Please check again ...! ' # . Html::tag('pre', VarDumper::dumpAsString(ArrayHelper::getColumn($modelsDetail, 'errors')))
         ]]);
      }

      return $this->render('_form_barang_keluar_delivery_receipt_step_2', [
         'model' => $model,
         'modelsDetail' => $modelsDetail,
         'modelsDetailDetail' => empty($modelsDetailDetail)
            ? [[new HistoryLokasiBarang()]]
            : $modelsDetailDetail,
      ]);
   }

   /**
    * @param $id
    * @return QuotationDeliveryReceipt|Response
    * @throws NotFoundHttpException
    */
   protected function findQuotationDeliveryReceiptHistoryLokasiBarangs($id): QuotationDeliveryReceipt|Response
   {
      $quotationDeliveryReceipt = QuotationDeliveryReceipt::findOne($id);
      if (!$quotationDeliveryReceipt) throw new NotFoundHttpException('Quotation Delivery Receipt tidak ditemukan dengan id: ' . $id);

      if ($quotationDeliveryReceipt->historyLokasiBarangs) {
         Yii::$app->session->setFlash('error', [[
            'title' => 'Gagal',
            'message' => $quotationDeliveryReceipt->nomor . ' sudah pernah terdaftar di pencatatan lokasi'
         ]]);

         return $this->redirect(
            !empty(Yii::$app->request->referrer)
               ? Yii::$app->request->referrer
               : ['/']
         );
      }

      return $quotationDeliveryReceipt;
   }
}