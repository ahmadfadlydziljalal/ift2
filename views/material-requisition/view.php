<?php

use app\enums\TextLinkEnum;
use app\models\User;
use mdm\admin\components\Helper;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\MaterialRequisition */
/* @see \app\controllers\MaterialRequisitionController::actionView() */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Material Request', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-requisition-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
            <?= Html::a(TextLinkEnum::LIST->value, ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a(TextLinkEnum::BUAT_LAGI->value, ['create'], ['class' => 'btn btn-success']) ?>

        </div>
    </div>
    <div class="d-flex flex-row gap-1 mb-3">
        <?= Html::a(TextLinkEnum::KEMBALI->value, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a('<div class="d-flex flex-nowrap gap-1">' . TextLinkEnum::PRINT->value . ' Material Requisition </div>', ['print', 'id' => $model->id], [
            'class' => 'btn btn-outline-success',
            'target' => '_blank',
            'rel' => 'noopener noreferrer'
        ]) ?>

        <?= Html::a(TextLinkEnum::UPDATE->value, ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        <?php
        if (Helper::checkRoute('delete')) :
            echo Html::a(TextLinkEnum::DELETE->value, ['delete', 'id' => $model->id], [
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
        <div class="col-sm-12 col-md-6">
            <?php try {
                echo DetailView::widget([
                    'model' => $model,
                    'options' => [
                        'class' => 'table table-bordered table-detail-view'
                    ],
                    'attributes' => [
                        'nomor',
                        [
                            'attribute' => 'vendor_id',
                            'value' => $model->vendor->nama,
                        ],
                        'tanggal:date',
                        'remarks:ntext',
                        [
                            'attribute' => 'approved_by',
                            'value' => $model->approvedBy->nama,
                        ],
                        [
                            'attribute' => 'acknowledge_by',
                            'value' => $model->acknowledgeBy->nama,
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => 'datetime',
                        ],
                        /*[
                            'attribute' => 'updated_at',
                            'format' => 'datetime',
                        ],*/
                        [
                            'attribute' => 'created_by',
                            'value' => function ($model) {
                                return User::findOne($model->created_by)->username ?? null;
                            }
                        ],
                        /*[
                              'attribute' => 'updated_by',
                              'value' => function ($model) {
                                  return User::findOne($model->updated_by)->username ?? null;
                              }
                        ],*/
                    ],
                ]);


            } catch (Exception $e) {
                echo $e->getMessage();
            } catch (Throwable $e) {
                echo $e->getMessage();
            }
            ?>
        </div>

    </div>

    <div class="d-flex flex-row gap-1 mb-3">
        <?= Html::a('<div class="d-flex flex-nowrap gap-1">' . TextLinkEnum::PRINT->value . ' Penawaran Harga</div>', ['material-requisition/print-penawaran', 'id' => $model->id], [
            'class' => 'btn btn-outline-success',
            'target' => '_blank',
            'rel' => 'noopener noreferrer'
        ]) ?>
    </div>

    <?php
    echo ListView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query' => $model->getMaterialRequisitionDetails()
        ]),
        'itemView' => function ($model, $key, $index, $widget) {
            return $this->render('_view_detail_penawaran', [
                'model' => $model
            ]);
        },
        'options' => [
            'class' => 'd-flex flex-column gap-3 '
        ]
    ]);
    ?>
</div>