<?php

namespace app\controllers;


use app\models\search\StockSearch;
use Yii;
use yii\web\Controller;

class StockController extends Controller
{
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
}
