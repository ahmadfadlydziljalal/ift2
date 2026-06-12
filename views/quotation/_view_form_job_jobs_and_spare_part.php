<?php

/* @var $this yii\web\View */

/* @var $model app\models\Quotation|string|ActiveRecord */

use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Html;

?>

<div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-2">

    <div class="col mb-2">
        <div class="d-flex flex-column gap-1 flex-wrap">
            <h5>Jobs</h5>
            <?php
            $jobs = $model->quotationFormJob->getQuotationFormJobJobs()->count();
            if (empty($jobs)) {
                echo Html::tag('div', Html::a('<i class="bi bi-plus-circle"></i> Definisikan!', ['quotation/create-form-job-type', 'id' => $model->quotationFormJob->id], ['class' => 'btn btn-outline-success']));
            } else {
                echo Html::tag('div',
                    Html::a('<i class="bi bi-pencil"></i> Update!', ['quotation/update-form-job-type', 'id' => $model->quotationFormJob->id], ['class' => 'btn btn-outline-primary']) .
                    Html::a('<i class="bi bi-trash"></i> Delete!', ['quotation/delete-form-job-type', 'id' => $model->quotationFormJob->id], [
                        'class' => 'btn btn-outline-danger',
                        'data'  => [
                            'confirm' => 'Apakah anda yakin ingin menghapus data ini?',
                            'method'  => 'post',
                        ]
                    ]),
                    [
                        'class' => 'd-inline-flex gap-1 mb-2'
                    ]
                );
                echo GridView::widget([
                    'dataProvider' => new ActiveDataProvider([
                        'query'      => $model->quotationFormJob->getQuotationFormJobJobs()
                            ->joinWith(['satuan'])
                            ->orderBy(['id' => SORT_ASC]),
                        'pagination' => false
                    ]),
                    'layout'       => "{items}",
                    'responsive'   => true,
                    'columns'      => [
                        'nama',
                        [
                            'attribute'      => 'quantity',
                            'contentOptions' => [
                                'class' => 'text-wrap text-end'
                            ],
                            'headerOptions'  => [
                                'class' => 'text-nowrap text-end'
                            ]
                        ],
                        [
                            'attribute'      => 'satuan_id',
                            'value'          => 'satuan.nama',
                            'contentOptions' => [
                                'class' => 'text-wrap'
                            ]
                        ]
                    ]
                ]);
            } ?>
        </div>
    </div>
    <div class="col mb-2">
        <div class="d-flex flex-column gap-1 flex-wrap">
            <h5>Spare Part Estimation</h5>
            <?php
            $spareParts = $model->quotationFormJob->getQuotationFormJobSpareParts()->count();
            if (empty($spareParts)) {
                echo Html::tag('div', Html::a('<i class="bi bi-plus-circle"></i> Definisikan!', ['quotation/create-form-job-service-part-type', 'id' => $model->quotationFormJob->id], ['class' => 'btn btn-outline-success']));
            } else {
                echo Html::tag('div',
                    Html::a('<i class="bi bi-pencil"></i> Update!', ['quotation/update-form-job-service-part-type', 'id' => $model->quotationFormJob->id], ['class' => 'btn btn-outline-primary']) .
                    Html::a('<i class="bi bi-trash"></i> Delete!', ['quotation/delete-form-job-service-part-type', 'id' => $model->quotationFormJob->id], [
                        'class' => 'btn btn-outline-danger',
                        'data'  => [
                            'confirm' => 'Apakah anda yakin ingin menghapus data ini?',
                            'method'  => 'post',
                        ]
                    ]),
                    [
                        'class' => 'd-inline-flex gap-1 mb-2'
                    ]
                );
                echo GridView::widget([
                    'dataProvider' => new ActiveDataProvider([
                        'query'      => $model->quotationFormJob->getQuotationFormJobSpareParts()
                            ->joinWith(['satuan', 'barang'])
                            ->orderBy(['id' => SORT_ASC]),
                        'pagination' => false
                    ]),
                    'layout'       => "{items}",
                    'responsive'   => true,
                    'columns'      => [
                        'barang.nama',
                        [
                            'attribute'      => 'quantity',
                            'contentOptions' => [
                                'class' => 'text-wrap text-end'
                            ],
                            'headerOptions'  => [
                                'class' => 'text-nowrap text-end'
                            ]
                        ],
                        [
                            'attribute'      => 'satuan_id',
                            'value'          => 'satuan.nama',
                            'contentOptions' => [
                                'class' => 'text-wrap'
                            ]
                        ]
                    ]
                ]);
            } ?>
        </div>
    </div>
</div>
