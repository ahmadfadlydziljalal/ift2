<?php

namespace app\controllers;


use app\models\Barang;
use app\models\search\StockInPerBarangSearch;
use app\models\search\StockSearch;
use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;

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

   public function actionViewStockIn(int $id): string
   {
      $searchModel = new StockInPerBarangSearch([
         'barang' => Barang::findOne($id)
      ]);

      $dataProvider = $searchModel->search(
         Yii::$app->request->queryParams,
         $id
      );

      return $this->render('view_stock_in', [
         'searchModel' => $searchModel,
         'dataProvider' => $dataProvider,
      ]);
   }
}