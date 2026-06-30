<?php


/* @var $today string */
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StockSearch */

/* @var $dataProvider ActiveDataProvider */
/* @var $dataProviderForExportMenu yii\data\ActiveDataProvider */

use kartik\bs5dropdown\ButtonDropdown;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\bootstrap5\Html;

$this->title = 'Stock';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="stock-index">
    <div class="d-flex flex-column gap-3">
        <div class="d-flex justify-content-between flex-wrap align-items-center">
            <h1><?= Html::encode($this->title) ?></h1>
            <div>
                <?= ButtonDropdown::widget([
                    'label' => 'Print Sticker',
                    'dropdown' => [
                        'items' => [
                            ['label' => 'Multiple Sticker', 'url' => ['stock/print-multiple-sticker']],

                        ],
                    ],
                    'buttonOptions' => [
                        'class' => 'btn btn-primary'
                    ]
                ])  ?>

                <?= ExportMenu::widget([
                    'dataProvider' => $dataProviderForExportMenu,
                    'columns'      => require(__DIR__ . DIRECTORY_SEPARATOR . '_columns.php'),
                    'filename'     => 'Laporan Updated Stock ' . $today,
                    'exportConfig' => [
                        ExportMenu::FORMAT_TEXT => false,
                        ExportMenu::FORMAT_HTML => false,
                        ExportMenu::FORMAT_PDF  => [
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
            'rowOptions'   => [
                'class' => 'align-middle'
            ],
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => require(__DIR__ . DIRECTORY_SEPARATOR . '_columns.php')
        ]); ?>

    </div>
</div>