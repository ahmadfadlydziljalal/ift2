<?php


/* @var $this View */
/* @see \app\controllers\TandaTerimaBarangController::actionPreviewLaporanIncoming() */

/* @var $model LaporanIncomingTandaTerimaBarang */

use app\enums\TextLinkEnum;
use app\models\form\LaporanIncomingTandaTerimaBarang;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\web\View;

$this->title = $model->tanggal;
$this->params['breadcrumbs'][] = ['label' => 'Tanda Terima Barang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Laporan Incoming', 'url' => ['laporan-incoming']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="preview-data">

    <h1>Laporan Incoming: <?= $model->tanggal ?></h1>
    <div class=" d-flex flex-column gap-2">
        <?php
        $dataProvider = new ArrayDataProvider([
            'allModels' => $model->getData(),
            'pagination' => false,
            'sort' => false
        ]);

        $gridColumns = [
            ['class' => SerialColumn::class],
            'tanggal:date',
            'part_number',
            'kode_barang',
            'nama_barang',
            'jumlah_masuk',
            'keterangan',
            'nomor_tanda_terima'
        ]; ?>

        <div class="d-flex flex-row gap-2">

            <?= Html::a(TextLinkEnum::LIST->value, ['tanda-terima-barang/index'], [
                'class' => 'btn btn-primary'
            ]) ?>

            <?php
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns,
                'clearBuffers' => true,
                'target' => ExportMenu::TARGET_BLANK,
                'dropdownOptions' => [
                    'icon' => '<i class="bi bi-download"></i>',
                    'label' => 'Download',
                    'class' => 'btn btn-outline-success'
                ],
                'columnSelectorOptions' => [
                    'icon' => '<i class="bi bi-list-columns"></i>',
                    'label' => 'Kolom'
                ],
                'filename' => 'Laporan Incoming sampai tanggal ' . $model->tanggal
            ]);
            ?>
        </div>
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
        ]);
        ?>
    </div>

</div>