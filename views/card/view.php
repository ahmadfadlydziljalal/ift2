<?php

use app\components\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use mdm\admin\components\Helper;
use yii\bootstrap5\Html as Bootstrap5Html;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Card */
/* @see app\controllers\CardController::actionView() */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Card', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card-view">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="my-0"><?= Html::encode($this->title) ?></h1>
        <div class="ms-md-auto ms-lg-auto">
            <?= Html::a('Index Card', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Buat card lain', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12  col-md-6">

            <div class="d-flex flex-row flex-wrap align-items-center mb-3" style="gap: .5rem">

                <?= Html::a('<i class="bi bi-arrow-left"></i> Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>

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

            <?php try {
                echo DetailView::widget([
                    'model' => $model,
                    'options' => [
                        'class' => 'table table-bordered table-detail-view'
                    ],
                    'attributes' => [
                        'nama',
                        'kode',
                        [
                            'label' => 'Type',
                            'format' => 'raw',
                            'value' => implode(", ", ArrayHelper::getColumn(ArrayHelper::toArray($model->cardTypes), 'nama'))
                        ],
                        'alamat:nText',
                        'npwp',
                    ],
                ]);
            } catch (Throwable $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
        <div class="col-sm-12  col-md-6">

            <div class="mb-3">
                <?= Bootstrap5Html::a('Tambah P.I.C', ['/card-person-in-charge/create', 'cardId' => $model->id], [
                    'class' => 'btn btn-primary'
                ]) ?>
            </div>

            <?= GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getCardPersonInCharges(),
                    'pagination' => false
                ]),
                'layout' => '{items}',
                'columns' => [
                    ['class' => SerialColumn::class],
                    'nama',
                    'telepon',
                    'email',
                    [
                        'class' => 'app\components\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="bi bi-pencil-fill"></i>',
                                    ['card-person-in-charge/update', 'id' => $model->id]
                                );
                            },
                            'delete' => function ($url, $model) {
                                return Html::a(
                                    '<i class="bi bi-trash-fill"></i>',
                                    ['card-person-in-charge/delete', 'id' => $model->id],
                                    [
                                        'data-method' => 'post',
                                        'data-confirm' => 'Are you sure to delete this ' . $model->nama . ' ?'
                                    ]
                                );
                            },
                        ],
                    ]
                ]
            ]) ?>
        </div>
    </div>

    <div class="d-flex justify-content-center">

        <hr class="text-muted p-1 w-75"
        / >
    </div>


    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <?= Html::a('<i class="bi bi-plus-circle"></i> Tambah Equipment', ['card-own-equipment/create', 'cardId' => $model->id], [
                    'class' => 'btn btn-primary'
                ]) ?>
            </div>

            <?= GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => $model->getCardOwnEquipments(),
                    'pagination' => false
                ]),
                'layout' => '{items}',
                'rowOptions' => [
                    'style' => [
                        'vertical-align' => 'middle'
                    ],
                ],
                'columns' => [
                    ['class' => SerialColumn::class],
                    'nama',
                    'lokasi:nText',
                    'tanggal_produk:date',
                    'serial_number',
                    [
                        'class' => 'app\components\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a(
                                    '<i class="bi bi-pencil-fill"></i>',
                                    ['/card-own-equipment/update', 'id' => $model->id]
                                );
                            },
                            'delete' => function ($url, $model) {
                                return Html::a(
                                    '<i class="bi bi-trash-fill"></i>',
                                    ['/card-own-equipment/delete', 'id' => $model->id],
                                    [
                                        'data-method' => 'post',
                                        'data-confirm' => 'Are you sure to delete this ' . $model->nama . ' ?'
                                    ]
                                );
                            },
                        ],
                    ]
                ]
            ]) ?>
        </div>
    </div>

</div>