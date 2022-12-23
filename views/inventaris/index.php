<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InventarisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataProviderForExportMenu yii\data\ActiveDataProvider */
/* @var $today string */
/* @see app\controllers\InventarisController::actionIndex() */

$this->title = 'Inventaris';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="inventaris-index">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
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
           <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

   <?php try {
      echo GridView::widget([
         'dataProvider' => $dataProvider,
         'filterModel' => $searchModel,
         'columns' => require(__DIR__ . '/_columns.php'),
      ]);
   } catch (Exception $e) {
      echo $e->getMessage();
   } catch (Throwable $e) {
      echo $e->getMessage();
   }

   ?>

</div>