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

    <div class="d-flex flex-column gap-2">
        <div class="d-flex justify-content-between flex-wrap align-items-center">
            <div>
                <h1><?= Html::encode($this->title) ?></h1>
            </div>

            <div>
               <?= Html::a('<i class="bi bi-diagram-2"></i> As Diagram', ['stock-per-gudang/view-per-card-as-diagram', 'id' => Yii::$app->request->queryParams['id']], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

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

</div>