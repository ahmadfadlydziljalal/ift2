<?php

use app\models\Card;
use app\models\search\StockPerGudangByCardSearch;
use kartik\grid\GridView;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $card Card|null */
/* @var $searchModel StockPerGudangByCardSearch */
/* @var $dataProvider */

$this->title = 'Stock di ' . $card->nama;
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="stock-per-gudang-index">
    <h1><?= Html::encode($this->title) ?></h1>

   <?php try {
      echo GridView::widget([
         'tableOptions' => [
            'class' => 'table table-gridview table-fixes-last-column'
         ],
         'dataProvider' => $dataProvider,
         'filterModel' => $searchModel,
         'rowOptions' => [
            'class' => 'text-nowrap align-middle'
         ],
         'columns' => require(__DIR__ . DIRECTORY_SEPARATOR . '_columns.php')
      ]);
   } catch (Throwable $e) {
      throw new InvalidConfigException($e->getMessage());
   } ?>


</div>