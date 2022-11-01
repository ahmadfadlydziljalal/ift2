<?php

use app\enums\TextLinkEnum;
use app\models\User;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use mdm\admin\components\Helper;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MaterialRequisition */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Material Requisitions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-requisition-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">

            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>

        </div>
    </div>
    <div class="d-flex flex-row gap-1 mb-3">
        <?= Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a(TextLinkEnum::PRINT->value, ['print', 'id' => $model->id], [
            'class' => 'btn btn-outline-primary',
            'target' => '_blank',
            'rel' => 'noopener noreferrer'
        ]) ?>

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
                'nomor',
                [
                    'attribute' => 'vendor_id',
                    'value' => $model->vendor->nama,
                ],
                'tanggal:date',
                'remarks:ntext',
                'approved_by',
                'acknowledge_by',
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
                /*  [
                      'attribute' => 'updated_by',
                      'value' => function ($model) {
                          return User::findOne($model->updated_by)->username ?? null;
                      }
                  ],*/
            ],
        ]);

        echo Html::tag('h2', 'Material Requisition Detail');
        echo !empty($model->materialRequisitionDetails) ?
            GridView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $model->materialRequisitionDetails
                ]),
                'columns' => [
                    // [
                    // 'class'=>'\yii\grid\DataColumn',
                    // 'attribute'=>'id',
                    // ],
                    // [
                    // 'class'=>'\yii\grid\DataColumn',
                    // 'attribute'=>'material_requisition_id',
                    // ],
                    [
                        'class' => SerialColumn::class
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'tipePembelian',
                        'value' => 'barang.tipePembelian.nama'
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'barang_id',
                        'value' => 'barang.nama'
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'description',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'quantity',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'satuan_id',
                        'value' => 'satuan.nama'
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'waktu_permintaan_terakhir',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'harga_terakhir',
                    ],
                    [
                        'class' => '\kartik\grid\DataColumn',
                        'attribute' => 'stock_terakhir',
                    ],
                ]
            ]) :
            Html::tag("p", 'Material Requisition Detail tidak tersedia', [
                'class' => 'text-warning font-weight-bold p-3'
            ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</div>