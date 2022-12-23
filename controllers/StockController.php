<?php

namespace app\controllers;


use app\models\Barang;
use app\models\form\SetLokasiBarangInForm;
use app\models\form\SetLokasiBarangMovementForm;
use app\models\form\SetLokasiBarangMovementFromForm;
use app\models\HistoryLokasiBarang;
use app\models\search\StockInPerBarangSearch;
use app\models\search\StockSearch;
use app\models\Status;
use app\models\Tabular;
use app\models\TandaTerimaBarangDetail;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class StockController extends Controller
{
   /**
    * @return string
    * @throws InvalidConfigException
    */
   public function actionIndex(): string
   {
      $searchModel = new StockSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      $dataProviderForExportMenu = clone $dataProvider;
      $dataProviderForExportMenu->pagination = false;

      $today = Yii::$app->formatter->asDate(date('Y-m-d H:i'), 'php:d-m-Y H:i');

      return $this->render('index', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
         'dataProviderForExportMenu' => $dataProviderForExportMenu,
         'today' => $today
      ]);
   }

   /**
    * @param int $id
    * @return string
    */
   public function actionView(int $id): string
   {
      $searchModel = new StockInPerBarangSearch([
         'barang' => Barang::findOne($id)
      ]);

      $dataProvider = $searchModel->search(
         Yii::$app->request->queryParams,
         $id
      );

      return $this->render('view', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }

   /**
    * @throws NotFoundHttpException
    * @throws ServerErrorHttpException
    */
   public function actionSetLokasi($id, string $type): Response|string
   {
      $modelType = $this->findStatusSetLokasi($type);
      $modelTandaTerimaBarangDetail = $this->findTandaTerimaBarangDetailModel($id);

      $model = new SetLokasiBarangInForm([
         'tandaTerimaBarangDetail' => $modelTandaTerimaBarangDetail,
         'tipePergerakan' => $modelType,
      ]);
      $modelsDetail = [new HistoryLokasiBarang()];

      if ($this->request->isPost) {

         $modelsDetail = Tabular::createMultiple(HistoryLokasiBarang::class);
         Tabular::loadMultiple($modelsDetail, $this->request->post());

         $model->historyLokasiBarangs = $modelsDetail;
         if ($model->validate() && Tabular::validateMultiple($modelsDetail)) {

            if ($model->save()) {
               Yii::$app->session->setFlash('success', [['title' => 'Lokasi in berhasil di record.', 'message' => 'Congratulation ...!']]);
               return $this->redirect(['stock/view', 'id' => $modelTandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang_id]);
            }

         }

         Yii::$app->session->setFlash('error', [[
            'title' => 'Gagal insert lokasi',
            'message' => $model->errors
         ]]);

      }

      return $this->render('_form_set_lokasi', [
         'model' => $model,
         'modelsDetail' => $modelsDetail,
      ]);

   }

   /**
    * @param $type
    * @return Status|null
    * @throws NotFoundHttpException
    */
   protected function findStatusSetLokasi($type): ?Status
   {
      if (($model = Status::findOne(['section' => 'set-lokasi-barang', 'key' => $type])) !== null) {
         return $model;
      }

      throw new NotFoundHttpException('You got status not valid for status set lokasi: ' . $type);
   }

   /**
    * @param $id
    * @return TandaTerimaBarangDetail|null
    * @throws NotFoundHttpException
    */
   protected function findTandaTerimaBarangDetailModel($id): ?TandaTerimaBarangDetail
   {
      if (($model = TandaTerimaBarangDetail::findOne($id)) !== null) {
         return $model;
      }

      throw new NotFoundHttpException();
   }

   public function actionSetMovementLokasi($id): Response|string
   {
      $modelTandaTerimaBarangDetail = $this->findTandaTerimaBarangDetailModel($id);
      $historySebelumnya = HistoryLokasiBarang::findAll([
         'tanda_terima_barang_detail_id' => $id
      ]);

      $movementBarangModel = new SetLokasiBarangMovementForm();
      $movementBarangModel->tandaTerimaBarangDetail = $modelTandaTerimaBarangDetail;
      $movementBarangModel->totalItemTandaTerimaBarangDetail = $modelTandaTerimaBarangDetail->quantity_terima;


      $models = [];
      foreach ($historySebelumnya as $sebelumnya) {
         $models[] = new SetLokasiBarangMovementFromForm([
            'tipePergerakanFromId' => 9,
            'quantityFrom' => $sebelumnya->quantity,
            'blockFrom' => $sebelumnya->block,
            'rakFrom' => $sebelumnya->rak,
            'tierFrom' => $sebelumnya->tier,
            'rowFrom' => $sebelumnya->row,
         ]);
      }

      if ($this->request->isPost) {


         $models = Tabular::createMultiple(SetLokasiBarangMovementForm::class);
         Tabular::loadMultiple($models, $this->request->post());

         $movementBarangModel->movementBarangItems = $models;

         if ($movementBarangModel->validate() && Tabular::validateMultiple($models)) {
            return $this->redirect(['stock/view', 'id' => $modelTandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang_id]);
         }


      }

      return $this->render('_form_set_movement', [
         'models' => $models,
         'modelTandaTerimaBarangDetail' => $modelTandaTerimaBarangDetail,
         'movementBarangModel' => $movementBarangModel,
      ]);
   }

}