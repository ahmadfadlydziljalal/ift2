<?php


/** @see \app\controllers\SiteController::actionDashboard() */

/* @var $this View */


use yii\helpers\Html;
use yii\web\View;

$this->title = 'Dashboard';

?>

<div class="site-index d-flex flex-column">


    <h3>Alur Pembelian Barang</h3>
    <div class="row">

        <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
            <div class="card h-100 rounded position-relative">
                <div class="card-body">
                    <div class="d-flex flex-column gap-1 align-items-center text-center">

                        <?= Html::a('<i class="bi bi-bag fs-1"></i>', ['material-requisition/index'], [
                            'class' => 'stretched-link'
                        ]) ?>

                        <span class="card-title">Material Requisition</span>
                    </div>
                </div>

                <div class="position-absolute  top-100 badge rounded-circle p-sm-1 p-md-2 p-lg-2 d-none d-md-block d-lg-none bg-info"
                     style="z-index: 2; left: 98%; translate: 0 -32%; transform: rotate(135deg)">
                    <i class="bi bi-arrow-right-short text-dark p-0 m-0 fs-4"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
            <div class="card h-100 rounded position-relative">
                <div class="card-body">
                    <div class="d-flex flex-column gap-1 align-items-center text-center">
                        <i class="bi bi-aspect-ratio fs-1"></i>
                        <span class="card-title">Penawaran</span>
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

        <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
            <div class="card h-100 rounded position-relative">
                <div class="card-body">
                    <div class="d-flex flex-column gap-1 align-items-center text-center">
                        <?= Html::a('<i class="bi bi-truck fs-1"></i>', ['purchase-order/index'], [
                            'class' => 'stretched-link'
                        ]) ?>
                        <span class="card-title">Purchase Order</span>
                    </div>
                </div>

                <div class="position-absolute top-0 start-50 translate-middle badge rounded-circle shadow bg-info p-sm-1 p-md-2 p-lg-2 d-block d-md-none">
                    <i class="bi bi-arrow-down-short text-dark p-0 m-0 fs-4"></i>
                </div>

                <div class="position-absolute top-50 start-0 translate-middle badge rounded-circle shadow bg-info p-sm-1 p-md-2 p-lg-2 d-none d-md-none d-lg-block">
                    <i class="bi bi-arrow-right-short text-dark p-0 m-0 fs-4"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
            <div class="card h-100 rounded position-relative">
                <div class="card-body">
                    <div class="d-flex flex-column gap-1 align-items-center text-center">

                        <?= Html::a('<i class="bi bi-bag-check-fill fs-1"></i>', ['tanda-terima-barang/index'], [
                            'class' => 'stretched-link'
                        ]) ?>
                        <span class="card-title">Terima barang</span>
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

    </div>

</div>