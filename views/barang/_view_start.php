<?php

use app\models\Barang;
use app\models\HistoryLokasiBarang;
use app\models\Status;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Barang */

$statusId = Status::findOne([
        'section' => Status::SECTION_SET_LOKASI_BARANG,
        'key'     => 'start-pertama-kali-penerapan-sistem',
])?->id;

$dataProvider = new ActiveDataProvider([
        'query'      => HistoryLokasiBarang::find()->where(['barang_id' => $model->id, 'tipe_pergerakan_id' => $statusId]),
        'pagination' => false,
]);
?>

<div class="barang-view-start mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Start Stock</h2>
        <?= $dataProvider->totalCount
                ? Html::a('Restart', ['restart', 'id' => $model->id], ['class' => 'btn btn-outline-warning'])
                : Html::a('Start', ['start', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
    </div>
    <p>
        Initialize Stock Quantity: <strong><?= (float)$model->initialize_stock_quantity ?></strong>
        <?= $model->defaultSatuan ? ' ' . Html::encode($model->defaultSatuan->nama) : '' ?>
    </p>
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary'      => false,
            'emptyText'    => 'Barang ini belum di-start.',
            'columns'      => [
                    'nomor',
                    'quantity:decimal',
                    'card.nama:text:Gudang',
                    'block',
                    'rak',
                    'tier',
                    'row',
                    'catatan:ntext',
            ],
    ]) ?>
</div>
