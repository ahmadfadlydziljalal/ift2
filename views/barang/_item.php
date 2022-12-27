<?php
/** @var $model Barang */

use app\components\helpers\ArrayHelper;
use app\models\Barang;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap5\Html;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;


/** @var $model Barang */
$items = (Json::decode($model->satuanHarga));
$string = '';

if ($items) {
   ArrayHelper::multisort($items, 'vendor');
   $string .= GridView::widget([
      'tableOptions' => [
         'class' => 'table p-0 m-0'
      ],
      'dataProvider' => new ArrayDataProvider([
         'allModels' => $items,
         'pagination' => false
      ]),
      'layout' => '{items}',
      'columns' => [
         [
            'class' => SerialColumn::class
         ],
         'satuan',
         /* 'vendor',
          [
             'attribute' => 'harga_beli',
             'format' => ['decimal', 2],
             'contentOptions' => [
                'class' => 'text-end'
             ]
          ],
          [
             'attribute' => 'harga_jual',
             'format' => ['decimal', 2],
             'contentOptions' => [
                'class' => 'text-end'
             ]
          ],*/
      ],
   ]);
} ?>

<div class="d-flex flex-column align-items-center-center" style="gap: .5rem">
   <?php echo $string; ?>
    <div class="card bg-transparent">
        <div class="card-body">
           <?php echo Html::tag('span', "Keterangan: " . (!empty($model->keterangan) ? $model->keterangan : "-")); ?>
        </div>
    </div>
</div>