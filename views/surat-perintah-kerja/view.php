<?php

use mdm\admin\components\Helper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SuratPerintahKerja */
/* @see app\controllers\SuratPerintahKerjaController::actionView() */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Surat Perintah Kerja', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="surat-perintah-kerja-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

            <?= Html::a('<i class="bi bi-arrow-left"></i>', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a('<i class="bi bi-table"></i>', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('<i class="bi bi-pencil"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
            <?php
            if (Helper::checkRoute('delete')) :
                echo Html::a('<i class="bi bi-trash"></i>', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-outline-danger',
                    'data'  => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method'  => 'post',
                    ],
                ]);
            endif;
            ?>
            <?= Html::a('Buat SPK Lainnya', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="card" style="max-width: 36rem">

        <?= $this->render('_print', ['model' => $model]) ?>
        <div class="card-footer p-2 d-flex justify-content-end">
            <?= Html::a('<i class="bi bi-file-pdf"></i> Cetak', ['export', 'id' => $model->id, 'type' => 'pdf'], [
                    'class'  => 'btn btn-primary',
                    'target' => '_blank',
                ]
            ) ?>
        </div>

    </div>

    <?php
    /* try {
        echo DetailView::widget([
            'model'      => $model,
            'options'    => [
                'class' => 'table table-bordered table-detail-view'
            ],
            'attributes' => [
                'nomor',
                'tanggal:date',
                'judul:ntext',
                'pelaksana',
                'keterangan:ntext',
                'data_pendukung_lainnya:ntext',
            ],
        ]);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }*/
    ?>

</div>