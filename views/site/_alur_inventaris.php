<?php


/* @var $this View */

use yii\bootstrap5\Html;
use yii\web\View;

?>

<div class="alur-inventaris">

    <h1>Alur Inventaris</h1>

    <div class="row">

        <div class="col-sm-12 col-md-6 col-lg-2 mb-3">
            <div class="card h-100 bg-transparent rounded position-relative">
                <div class="card-body">
                    <div class="d-flex flex-column gap-1 align-items-center text-center">
                       <?= Html::a('<i class="bi bi-archive-fill fs-1"></i>', ['inventaris/index'], [
                          'class' => 'stretched-link'
                       ]) ?>
                        <span class="card-title">List Inventaris</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-2 mb-3">
            <div class="card h-100 bg-transparent rounded position-relative">
                <div class="card-body">
                    <div class="d-flex flex-column gap-1 align-items-center text-center">

                       <?= Html::a('<i class="bi bi-hammer fs-1"></i>', ['inventaris-laporan-perbaikan-master/index'], [
                          'class' => 'stretched-link'
                       ]) ?>
                        <span class="card-title">Laporan Perbaikan</span>
                    </div>

                    <div class="position-absolute top-0 start-50 translate-middle badge rounded-circle shadow bg-info p-sm-1 p-md-2 p-lg-2 d-block d-md-none">
                        <i class="bi bi-arrow-down-short text-dark p-0 m-0 fs-4"></i>
                    </div>

                    <div class="position-absolute top-50 start-0 translate-middle badge rounded-circle shadow bg-info p-sm-1 p-md-2 p-lg-2 d-none d-md-none d-lg-block">
                        <i class="bi bi-arrow-right-short text-dark p-0 m-0 fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>