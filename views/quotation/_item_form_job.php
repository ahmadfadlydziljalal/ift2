<?php

/* @var $model QuotationFormJob */

use app\models\QuotationFormJob;
use yii\helpers\Html;

?>


<div class="quotation-item border-bottom pb-3">
    <div class="d-flex flex-column gap-1">

        <div class="row row-cols-2 row-cols-sm-1 row-cols-md-2">
            <div class="col">
                <div class="fw-bold">
                    <?= $model->nomor ?>
                </div>

                <?php
                if ($model->cardOwnEquipment) {
                    echo Html::tag('span',
                        '<i class="bi bi-truck"></i> ' .
                        $model->cardOwnEquipment->nama . ' - ' . $model->cardOwnEquipment->serial_number, [
                            'class' => 'badge bg-primary'
                        ]);
                }
                ?>

                <?= Html::tag('span', $model->hour_meter, [
                    'class' => 'badge bg-info'
                ]) ?>

                <?php


                echo Html::tag('span',
                    '<i class="bi bi-person-badge"></i> ' .
                    (!empty($model->person_in_charge) ? $model->person_in_charge : "No P.I.C"),
                    [
                        'class' => 'badge bg-success'
                    ])
                ?>

                <?php

                echo Html::tag('span',
                    '<i class="bi bi-person-check"></i> ' .
                    (!empty($model->mekanik) ? $model->mekanik->nama : "No Mekanik"), [
                        'class' => 'badge bg-success'
                    ]) ?>

            </div>
            <div class="col">
                <div class="float-end">
                    <strong>
                        <i class="bi bi-clock"></i>
                        <?= Yii::$app->formatter->asDate($model->tanggal) ?>
                    </strong>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-12 col-lg-6">
                <span class="fw-bold">Issue: </span> <br/>
                <p class="text-justify">
                    <?= empty($model->issue) ? "" : nl2br($model->issue) ?>
                </p>
            </div>

            <div class="col-12 col-lg-6">
                <span class="fw-bold">Remarks: </span> <br/>
                <p class="text-justify">
                    <?= empty($model->remarks) ? "" : nl2br($model->remarks) ?>
                </p>
            </div>

        </div>
    </div>

</div>