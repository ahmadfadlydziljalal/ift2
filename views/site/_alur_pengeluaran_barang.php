<?php


/* @var $this View */

use yii\bootstrap5\Html;
use yii\web\View;

?>

<div class="alur-pengeluaran barang">
    <h1>Alur Pengeluaran Barang</h1>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-2 mb-3">
            <div class="card h-100 bg-transparent rounded position-relative">
                <div class="card-body">
                    <div class="d-flex flex-column gap-1 align-items-center text-center">
                       <?= Html::a('<i class="bi bi-body-text fs-1"></i>', ['quotation/index'], [
                          'class' => 'stretched-link'
                       ]) ?>
                        <span class="card-title">Quotation</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-2 mb-3">
            <div class="card h-100 bg-transparent rounded position-relative">
                <div class="card-body">
                    <div class="d-flex flex-column gap-1 align-items-center text-center">
                        <i class="bi bi-aspect-ratio fs-1"></i>
                        <span class="card-title">Delivery Receipt</span>
                    </div>
                </div>
                <div class="position-absolute top-0 start-50 translate-middle badge rounded-circle shadow bg-info p-sm-1 p-md-2 p-lg-2 d-block d-md-none">
                    <i class="bi bi-arrow-down-short text-dark p-0 m-0 fs-4"></i>
                </div>

                <div class="position-absolute top-50 start-0 translate-middle badge rounded-circle shadow bg-info p-sm-1 p-md-2 p-lg-2 d-none d-md-block">
                    <i class="bi bi-arrow-right-short text-dark p-0 m-0 fs-4"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-2 mb-3">
            <div class="card h-100 bg-transparent rounded position-relative">
                <div class="card-body">
                    <div class="d-flex flex-column gap-1 align-items-center text-center">

                       <?= Html::a('<i class="bi bi-flag-fill fs-1"></i>', ['quotation/laporan-outgoing'], [
                          'class' => 'stretched-link'
                       ]) ?>
                        <span class="card-title">Laporan Outgoing</span>
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