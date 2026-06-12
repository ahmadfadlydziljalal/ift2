<?php

use app\enums\TextLinkEnum;
use kartik\bs5dropdown\ButtonDropdown;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\QuotationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @see app\controllers\QuotationController::actionIndex() */

$this->title = 'Quotation';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="quotation-index">

    <div class="d-flex flex-column gap-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
            <div class="ms-md-auto ms-lg-auto">
                <?php // $this->render('_search', ['model' => $searchModel]) ?>
                <?= ButtonDropdown::widget([
                    'label'         => TextLinkEnum::BUTTON_DROPDOWN_REPORTS->value,
                    'dropdown'      => [
                        'items'        => [
                            [
                                'label' => '<span class="bi bi-file"></span> Per Periode',
                                'url'   => ['quotation/laporan-per-periode']
                            ],
                            [
                                'label' => '<span class="bi bi-file"></span> Outgoing',
                                'url'   => ['quotation/laporan-outgoing']
                            ],
                        ],
                        'encodeLabels' => false,
                    ],
                    'encodeLabel'   => false,
                    'buttonOptions' => [
                        'class' => 'btn btn-secondary'
                    ]
                ]) ?>
                <?= Html::a('<i class="bi bi-plus-circle-dotted"></i>' . ' Tambah', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

        <?php

        try {
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'columns'      => require(__DIR__ . '/_columns.php'),
            ]);
        } catch (Throwable $e) {
            echo $e->getMessage();
        }

        /*try {
           echo ListView::widget([
              'dataProvider' => $dataProvider,
              'itemView' => '_item',
              'options' => [
                 'class' => 'd-flex flex-column gap-4'
              ]
           ]);
        } catch (Throwable $e) {
           echo $e->getMessage();
        }*/

        ?>
    </div>


</div>