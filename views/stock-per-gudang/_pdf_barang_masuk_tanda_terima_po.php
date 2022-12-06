<?php


/* @var $this View */

/* @var $model TandaTerimaBarang|null */

/** @var TandaTerimaBarangDetail $tandaTerimaBarangDetail */

use app\models\TandaTerimaBarang;
use app\models\TandaTerimaBarangDetail;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\web\View;

?>


<p class="font-weight-bold text-center">Tanda Terima Purchase Order: <?= $model->nomor ?></p>

<table class="table table-bordered">
    <tbody>

    <?php foreach ($model->tandaTerimaBarangDetails as $i => $tandaTerimaBarangDetail): ?>
        <tr>
            <td><?= ($i + 1) ?></td>
            <td>
                <p> Quantity Terima: <?= $tandaTerimaBarangDetail->quantity_terima ?></p>

               <?= GridView::widget([
                  'dataProvider' => new ActiveDataProvider([
                     'query' => $tandaTerimaBarangDetail->getHistoryLokasiBarangs(),
                     'pagination' => false,
                     'sort' => false
                  ]),
                  'columns' => [
                     [
                        'class' => SerialColumn::class
                     ],
                     [
                        'class' => DataColumn::class,
                        'attribute' => 'card_id',
                        'value' => 'card.nama'
                     ],
                     'quantity',
                     'block',
                     'rak',
                     'tier',
                     'row',
                  ],
                  'layout' => '{items}'
               ]) ?>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>