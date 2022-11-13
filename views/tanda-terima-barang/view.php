<?php

use app\enums\TextLinkEnum;
use app\models\TandaTerimaBarang;
use mdm\admin\components\Helper;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\TandaTerimaBarang */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Tanda Terima Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tanda-terima-barang-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="d-flex flex-row gap-2 mb-3">
        <?= Html::a(TextLinkEnum::KEMBALI->value, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a(TextLinkEnum::PRINT->value, ['print', 'id' => $model->id], [
            'class' => 'btn btn-outline-success',
            'target' => '_blank',
            'rel' => 'noopener noreferrer'
        ]) ?>
        <?= Html::a(TextLinkEnum::UPDATE->value, ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        <?php
        if (Helper::checkRoute('delete')) :
            echo Html::a(TextLinkEnum::HAPUS->value, ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        endif;
        ?>
    </div>

    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <?php try {
                echo DetailView::widget([
                    'model' => $model,
                    'options' => [
                        'class' => 'table table-bordered table-detail-view'
                    ],
                    'attributes' => [
                        'nomor',
                        'tanggal:date',
                        'catatan:ntext',
                        'received_by',
                        'messenger',
                        'acknowledge_by_id',
                        [
                            'attribute' => 'created_at',
                            'format' => 'datetime',
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format' => 'datetime',
                        ],
                        [
                            'attribute' => 'created_by',
                            'value' => function ($model) {
                                return app\models\User::findOne($model->created_by)->username;
                            }
                        ],
                        [
                            'attribute' => 'updated_by',
                            'value' => function ($model) {
                                return app\models\User::findOne($model->updated_by)->username;
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function ($model) {
                                /** @var TandaTerimaBarang $model */
                                return $model->getStatusInHtmlLabel();
                            }
                        ],
                    ],
                ]);

            } catch (Exception $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>

    <?php
    echo ListView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getMaterialRequisitionDetailPenawarans()
        ]),
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_view_detail', [
                'model' => $model,
                'index' => $index
            ]);
        },
        'layout' => '{items}'
    ]);
    ?>


</div>