<?php

use app\enums\TextLinkEnum;
use kartik\grid\GridView;
use yii\bootstrap5\ButtonDropdown;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TandaTerimaBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tanda Terima Barang';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tanda-terima-barang-index">

    <div class="d-flex justify-content-between flex-row flex-wrap mb-2">

        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>

        <div class="">
            <?= Html::a(TextLinkEnum::RESET_FILTER->value, ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= ButtonDropdown::widget([
                'label' => TextLinkEnum::BUTTON_DROPDOWN_REPORTS->value,
                'dropdown' => [
                    'items' => [
                        [
                            'label' => '<span class="bi bi-file"></span> Incoming',
                            'url' => ['tanda-terima-barang/laporan-incoming']
                        ],
                    ],
                    'encodeLabels' => false,
                ],
                'encodeLabel' => false,
                'buttonOptions' => [
                    'class' => 'btn btn-outline-secondary'
                ]
            ]) ?>
            <?= Html::a(TextLinkEnum::TAMBAH->value, ['tanda-terima-barang/before-create'], ['class' => 'btn btn-success']) ?>
        </div>

    </div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require(__DIR__ . '/_columns.php'),
        'panel' => false,
        'bordered' => true,
        'striped' => false,
        'headerContainer' => [],
    ]);
    ?>

</div>