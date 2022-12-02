<?php

namespace app\controllers;


use app\models\Barang;
use app\models\HistoryLokasiBarang;
use app\models\search\StockInPerBarangSearch;
use app\models\search\StockSearch;
use app\models\Status;
use app\models\Tabular;
use app\models\TandaTerimaBarangDetail;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
    */
   public function actionSetLokasi($id, string $type): Response|string
   {
      $modelType = $this->findStatusSetLokasi($type);
      $modelTandaTerimaBarangDetail = $this->findTandaTerimaBarangDetailModel($id);
      $models = [new HistoryLokasiBarang()];

      if ($this->request->isPost) {

         $models = Tabular::createMultiple(HistoryLokasiBarang::class);
         Tabular::loadMultiple($models, $this->request->post());

         $error = '';
         if (Tabular::validateMultiple($models)) {

            $transaction = HistoryLokasiBarang::getDb()->beginTransaction();

            try {

               $flag = true;

               /** @var HistoryLokasiBarang $model */
               foreach ($models as $model) {

                  $model->tanda_terima_barang_detail_id = $id;
                  $model->tipe_pergerakan_id = $modelType->id;

                  $flag = $model->save(false);
                  if (!$flag) break;
               }

               if ($flag) {
                  $transaction->commit();
                  Yii::$app->session->setFlash('success', [[
                     'title' => 'Lokasi in berhasil di record.',
                     'message' => $error
                  ]]);
                  return $this->redirect(['stock/view', 'id' => $modelTandaTerimaBarangDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang_id]);
               }

               $transaction->rollBack();

            } catch (Exception $e) {
               $transaction->rollBack();
               $error = $e->getMessage();
            }
         }

         Yii::$app->session->setFlash('error', [[
            'title' => 'Gagal insert lokasi',
            'message' => $error
         ]]);

      }

      return $this->render('_form_set_lokasi', [
         'models' => $models,
         'modelTandaTerimaBarangDetail' => $modelTandaTerimaBarangDetail
      ]);

   }

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

}