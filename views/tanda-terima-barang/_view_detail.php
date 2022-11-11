<?php

/* @var $this yii\web\View */
/* @var $model app\models\TandaTerimaBarang */
/* @var $index int */

use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use yii\helpers\StringHelper;
use yii\widgets\DetailView;
?>

<div class="card mb-4 border-1 item">

    <div class="card-body">
        <strong>
            <?= ($index + 1) . '. ' . StringHelper::basename(get_class($model)) ?>
        </strong>
    </div>
        

    <?php try { 
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                         // 'id',
                        'material_requisition_detail_id',
                        'vendor_id',
                        'mata_uang_id',
                        'quantity_pesan',
                        'harga_penawaran',
                        'status_id',
                        'purchase_order_id',
                         // 'tanda_terima_barang_id',
                         // 'created_at',
                         // 'updated_at',
                         // 'created_by',
                         // 'updated_by',
            ],
        ]);

        echo GridView::widget([
            'panel' => false,
            'bordered' => false,
            'striped' => false,
            'headerContainer' => [],
            'dataProvider' => new ActiveDataProvider([
                 'query' => $model->getTandaTerimaBarangDetails(),
                 'sort' => false,
                 'pagination' => false
            ]),
            'tableOptions' => [
                'class' => 'mb-0'
            ],
            'layout' => '{items}',
            'columns' =>[
                 [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions' => [
                        'style' => [
                            'width' => '2px'
                        ]
                    ],
                ],
                     // [
                          // 'class'=>'\yii\grid\DataColumn',
                          // 'attribute'=>'id',
                     // ],
                     // [
                          // 'class'=>'\yii\grid\DataColumn',
                          // 'attribute'=>'material_requisition_detail_penawaran_id',
                     // ],
                     [
                          'class'=>'\yii\grid\DataColumn',
                          'attribute'=>'tanggal',
                     ],
                     [
                          'class'=>'\yii\grid\DataColumn',
                          'attribute'=>'quantity_terima',
                     ],
           ]
       ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }
    ?>


</div>