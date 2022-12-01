<?php


/* @var $today string */
/* @var $this View */
/* @var $searchModel StockSearch */

/* @var $dataProvider ActiveDataProvider */

use app\models\search\StockSearch;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\bootstrap5\Html;
use yii\data\ActiveDataProvider;
use yii\web\View;

$this->title = 'Stock';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="stock-index">
    <div class="d-flex flex-column gap-3">
        <div class="d-flex justify-content-between flex-wrap align-items-center">
            <div>
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div>
               <?= Html::a('<i class="bi bi-repeat"></i>', ['index'], ['class' => 'btn btn-primary']) ?>
               <?= ExportMenu::widget([
                  'dataProvider' => $dataProviderForExportMenu,
                  'columns' => require(__DIR__ . DIRECTORY_SEPARATOR . '_columns.php'),
                  'filename' => 'Laporan Updated Stock ' . $today,
                  'exportConfig' => [
                     ExportMenu::FORMAT_TEXT => false,
                     ExportMenu::FORMAT_HTML => false,
                     ExportMenu::FORMAT_PDF => [
                        'pdfConfig' => [
                           'methods' => [
                              'SetHeader' => ['Laporan Updated Stock ' . $today],
                              'SetFooter' => ['{PAGENO}'],
                           ]
                        ],
                     ],
                  ]
               ]);
               ?>
            </div>
        </div>

       <?php echo GridView::widget([
          'tableOptions' => [
             'class' => 'table table-gridview table-fixes-last-column'
          ],
          'dataProvider' => $dataProvider,
          'filterModel' => $searchModel,
          'columns' => require(__DIR__ . DIRECTORY_SEPARATOR . '_columns.php')
       ]); ?>
    </div>
</div>