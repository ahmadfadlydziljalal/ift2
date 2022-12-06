<?php

namespace app\controllers;

use app\components\helpers\ArrayHelper;
use app\enums\TextLinkEnum;
use app\models\Card;
use app\models\ClaimPettyCash;
use app\models\ClaimPettyCashNotaDetail;
use app\models\form\ReportStockPerGudangBarangMasukDariTandaTerima;
use app\models\form\StockPerGudangBarangMasukDariClaimPettyCashForm;
use app\models\form\StockPerGudangBarangMasukDariTandaTerimaPoForm;
use app\models\HistoryLokasiBarang;
use app\models\search\LokasiBarangPerCardSearch;
use app\models\search\LokasiBarangSearch;
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
         return $this->redirect([
            'stock-per-gudang/barang-masuk-tanda-terima-po-step2',
            'id' => $model->nomorTandaTerimaId
         ]);
      }

      return $this->render(
         '_form_barang_masuk_tanda_terima_po_step_1',
         [
            'model' => $model
         ]
      );
   }

   /**
    * @param $id
    * @return Response|string
    * @throws ServerErrorHttpException
    */
   public function actionBarangMasukTandaTerimaPoStep2($id): Response|string
   {

      $tandaTerimaBarang = TandaTerimaBarang::findOne($id);

      if ($tandaTerimaBarang->historyLokasiBarangs) {
         Yii::$app->session->setFlash('error', [[
            'title' => 'Gagal',
            'message' => $tandaTerimaBarang->nomor . ' sudah pernah terdaftar di pencatatan lokasi'
         ]]);
         return $this->redirect(!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : ['/']);
      }

      $model = new StockPerGudangBarangMasukDariTandaTerimaPoForm([
         'tandaTerimaBarang' => $tandaTerimaBarang,
         'nomorTandaTerimaId' => $id
      ]);
      $model->scenario = $model::SCENARIO_STEP_2;

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
                  $modelHistoryLokasiBarang->tipe_pergerakan_id = 8;
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
                  'message' => 'Lokasi tanda terima berhasil di-simpan.',
                  'footer' => Html::a(
                     TextLinkEnum::PRINT->value,
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

         Yii::$app->session->setFlash('error', [[
            'title' => 'Gagal',
            'message' => 'Please check again ...!'
         ]]);
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
    * @return Response|string
    */
   public function actionBarangMasukClaimPettyCashStep1(): Response|string
   {
      $model = new StockPerGudangBarangMasukDariClaimPettyCashForm();
      $model->scenario = $model::SCENARIO_STEP_1;

      if ($model->load($this->request->post()) && $model->validate()) {
         return $this->redirect([
            'stock-per-gudang/barang-masuk-claim-petty-cash-step2',
            'id' => $model->nomorClaimPettyCashId
         ]);
      }

      return $this->render(
         '_form_barang_masuk_claim_petty_cash_step_1',
         [
            'model' => $model
         ]
      );
   }

   /**
    * @param $id
    * @return Response|string
    * @throws ServerErrorHttpException
    */
   public function actionBarangMasukClaimPettyCashStep2($id): Response|string
   {
      $claimPettyCash = ClaimPettyCash::findOne($id);

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

      $model = new StockPerGudangBarangMasukDariClaimPettyCashForm();
      $model->claimPettyCash = $claimPettyCash;
      $model->nomorClaimPettyCashId = $id;
      $model->scenario = $model::SCENARIO_STEP_2;

      $modelsDetail = $claimPettyCash->claimPettyCashNotaDetailsHaveStockType;

      $modelsDetailDetail = [];
      foreach ($modelsDetail as $i => $detail) {
         $modelsDetailDetail[$i][] = new HistoryLokasiBarang([
            'claim_petty_cash_nota_detail_id' => $detail->id,
         ]);
      }

      if ($this->request->isPost) {

         $modelsDetail = Tabular::createMultiple(
            ClaimPettyCashNotaDetail::class,
            $modelsDetail
         );

         Tabular::loadMultiple($modelsDetail, $this->request->post());
         $model->claimPettyCashNotaDetails = $modelsDetail;

         $isValid = true;
         if (isset($_POST['HistoryLokasiBarang'][0][0])) {

            foreach ($_POST['HistoryLokasiBarang'] as $i => $historyLokasiBarangs) {
               foreach ($historyLokasiBarangs as $j => $historyLokasiBarang) {
                  $data['HistoryLokasiBarang'] = $historyLokasiBarang;

                  $modelHistoryLokasiBarang = new HistoryLokasiBarang();
                  $modelHistoryLokasiBarang->load($data);
                  $modelHistoryLokasiBarang->tipe_pergerakan_id = 8;
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
                  'message' => 'Lokasi Claim Petty Cash berhasil di-simpan.',
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
   public function actionCreateReportBarangMasuk($modelName): string
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


   public function actionTransferBarangAntarGudang()
   {

   }

   public function actionBarangKeluar()
   {
   }
}