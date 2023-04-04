<?php

use kartik\grid\GridView;
use mdm\admin\components\Helper;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CardOwnEquipment */
/* @see app\controllers\CardOwnEquipmentController::actionView() */

$this->title = $model->nama . ' ' . $model->card->nama;
$this->params['breadcrumbs'][] = ['label' => 'Card Own Equipment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card-own-equipment-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
           <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
           <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
           <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
           <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
           <?php
           if (Helper::checkRoute('delete')) :
              echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                 'class' => 'btn btn-outline-danger',
                 'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                 ],
              ]);
           endif;
           ?>
        </div>
    </div>

    <div class="d-flex flex-column gap-3">
       <?= DetailView::widget([
          'model' => $model,
          'options' => [
             'class' => 'table table-bordered table-detail-view'
          ],
          'attributes' => [
             [
                'attribute' => 'card_id',
                'value' => $model->card->nama
             ],
             'nama',
             'lokasi',
             'tanggal_produk:date',
             'serial_number',
          ],
       ]);
       ?>

        <div class="d-flex gap-2">
           <?= Html::a('<i class="bi bi-plus-circle"></i> Tambah History', ['card-own-equipment/add-history-service', 'id' => $model->id], [
              'class' => 'btn btn-primary',
              'data-pjax' => '0'
           ]) ?>
        </div>

       <?= GridView::widget([
          'dataProvider' => new ActiveDataProvider([
             'query' => $model->getCardOwnEquipmentHistories()->orderBy('id ASC')
          ]),
          'columns' => require(__DIR__ . '/_columns_history_service.php')
       ]) ?>
    </div>

</div>