<?php


/** @see \app\controllers\SiteController::actionDashboard()  */
/* @var $this View */


use app\models\Faktur;
use yii\helpers\Html;
use yii\web\View;

?>

<div class="site-index d-flex flex-column">


    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">

        <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-title">Faktur Hari Ini</p>
                    <h4>
                        <?= Faktur::find()->countHariIni() ?>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-title">Jumlah Faktur</p>
                    <h4>
                        <?= Faktur::find()->count() ?>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-title">Total Faktur Belum Lunas</p>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <p class="card-title">Total Faktur Sudah Lunas</p>
                </div>
            </div>
        </div>

    </div>

</div>