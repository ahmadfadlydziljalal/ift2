<?php


/* @var $key string */

/* @var $model array */

use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\SerialColumn;

?>


<div class="material-requisition-item-group">

    <div class="card">

        <div class="card-header">
            <h5><?= $key ?></h5>
        </div>

        <div class="card-body">

            <?php


            $column = strtolower($key) === 'stock' ?
                [
                    [
                        'class' => SerialColumn::class
                    ],
                    [
                        'attribute' => 'barangPartNumber',
                        'header' => 'Part Number'
                    ],
                    [
                        'attribute' => 'barangIftNumber',
                        'header' => 'IFT Number'
                    ],
                    [
                        'attribute' => 'barangMerkPartNumber',
                        'header' => 'Merk'
                    ],
                    [
                        'attribute' => 'description',
                    ]
                ] :
                [
                    [
                        'class' => SerialColumn::class
                    ],
                    [
                        'attribute' => 'description',
                    ]
                ];
            ?>


            <?php
            try {
                echo GridView::widget([
                    'tableOptions' => [
                        'class' => 'table table-grid-view bg-white p-0 m-0'
                    ],
                    'dataProvider' => new ArrayDataProvider([
                        'allModels' => $model,
                        'pagination' => false,
                        'sort' => false
                    ]),
                    'layout' => '{items}',
                    'columns' => $column,
                ]);
            } catch (Throwable $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>

</div>