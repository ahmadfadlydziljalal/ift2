<?php

use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="barang-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3" style="gap: .5rem">
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


    <div class="row">

        <div class="col-12 col-lg-8">
           <?php
           echo DetailView::widget([
              'model' => $model,
              'options' => [
                 'class' => 'table table-bordered table-detail-view'
              ],
              'attributes' => [
                 [
                    'attribute' => 'tipe_pembelian_id',
                    'value' => $model->tipePembelian->nama
                 ],
                 'nama',
                 'part_number',
                 'merk_part_number',
                 'ift_number',
                 [
                    'attribute' => 'originalitas_id',
                    'value' => $model->originalitas->nama
                 ],

              ],
           ]);
           ?>
        </div>
        <div class="col-12 col-lg-4">

            <div class="d-flex flex-column gap-3">

                <div>
                   <?= Html::a('Upload Photo', ['barang/upload-photo', 'id' => $model->id], [
                      'class' => 'btn btn-primary'
                   ]) ?>
                </div>
                <div>
                   <?php if ($model->photo) : ?>
                       <div class="d-flex flex-column gap-3">

                           <div>
                              <?= Html::img($model->photo_thumbnail, [
                                 'alt' => 'No image available',
                                 'loading' => 'lazy'
                              ]) ?>
                           </div>


                          <?php /** @see \app\controllers\BarangController::actionDeletePhoto() */ ?>
                           <div>
                              <?= Html::a('<i class="bi bi-trash-fill"></i> Hapus', ['barang/delete-photo',
                                 'id' => $model->id
                              ], [
                                 'class' => 'btn btn-danger',
                                 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                 'data-method' => 'post',
                              ]); ?>
                           </div>

                       </div>

                   <?php endif; ?>
                </div>

            </div>

        </div>

    </div>

   <?= $this->render('_view_detail', ['model' => $model]) ?>


</div>