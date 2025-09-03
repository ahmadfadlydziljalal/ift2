<?php

use app\models\Card;
use app\models\form\LaporanQuotationPerPeriodForm;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\web\View;

/* @var $this View */
/* @var $model LaporanQuotationPerPeriodForm */
/* @see \app\controllers\QuotationController::actionLaporanPerPeriodeResult() */


$this->title = $model::optionsPeriodTypeLabel($model->periodType);
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Laporan Per Periode', 'url' => ['laporan-per-periode']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="quotation-laporan-per-periode-result d-flex flex-column gap-3">

    <?php
    $dataProvider = new ArrayDataProvider([
        'allModels' => $model->buildQuotationReportQuery()->all(Yii::$app->db),
        'pagination' => false,
    ]);
    ?>
    <div class="d-flex justify-content-between flex-wrap">

        <h1>Laporan <?= $model::optionsPeriodTypeLabel($model->periodType) ?> </h1>
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => require __DIR__ . '/laporan_per_periode_result_columns.php',
            'filename' => $model->getFilename(),
            'target' => ExportMenu::TARGET_SELF,
            'clearBuffers' => true,
            'exportConfig' => [
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_PDF => [
                    'pdfConfig' => [
                        'methods' => [
                            'SetHeader' => ['Laporan  ' . $model::optionsPeriodTypeLabel($model->periodType)],
                            'SetFooter' => ['{PAGENO}'],
                        ]
                    ],
                ],
            ]
        ]);
        ?>
    </div>

    <div>
        <?= $model->periodYear ?> <?= $model->periodMonthYear ?> <?= $model->periodDate ?>
        <?php if ($model->customerId) : ?>
            , <?= Card::findOne($model->customerId)->nama ?>
        <?php endif; ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => [
            'class' => 'text-wrap'
        ],
        'columns' => require __DIR__ . '/laporan_per_periode_result_columns.php',
    ]); ?>
</div>
