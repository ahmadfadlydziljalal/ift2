<?php

use mdm\admin\components\Helper;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-view">

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


    <div class="row">
        <div class="col-12 col-lg-8">
            <?php try {
            echo DetailView::widget([
                'model' => $model,
                'options' => [
                    'class' => 'table table-bordered table-detail-view'
                ],
                'attributes' => [
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
    </div>

    <?php

    echo Html::tag('h2', 'Barang Satuan');
    echo !empty($model->barangSatuans) ?
        GridView::widget([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $model->barangSatuans
            ]),
            'columns' => [
                // [
                // 'class'=>'\yii\grid\DataColumn',
                // 'attribute'=>'id',
                // ],
                // [
                // 'class'=>'\yii\grid\DataColumn',
                // 'attribute'=>'barang_id',
                // ],
                [
                    'class' => SerialColumn::class
                ],
                [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'vendor_id',
                    'value' => 'vendor.nama'
                ],
                [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'satuan_id',
                    'value' => 'satuan.nama'
                ],
                [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'harga_beli',
                    'format' => ['decimal', 2],
                    'contentOptions' => [
                        'class' => 'text-end'
                    ]
                ],
                [
                    'class' => '\yii\grid\DataColumn',
                    'attribute' => 'harga_jual',
                    'format' => ['decimal', 2],
                    'contentOptions' => [
                        'class' => 'text-end'
                    ]
                ],
            ]
        ]) :
        Html::tag("p", 'Barang Satuan tidak tersedia', [
            'class' => 'text-warning font-weight-bold p-3'
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>

</div>