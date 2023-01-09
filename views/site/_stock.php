<?php


/* @var $this View */

use app\models\Card;
use yii\bootstrap5\Html;
use yii\web\View;

?>

<div class="site-stock">
    <h1>Stock</h1>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-2 mb-3">
            <div class="card h-100 bg-transparent rounded position-relative">
                <div class="card-body">
                    <div class="d-flex flex-column gap-1 align-items-center text-center">
                       <?= Html::a('<i class="bi bi-body-text fs-1"></i>', ['stock/index'], [
                          'class' => 'stretched-link'
                       ]) ?>
                        <span class="card-title">All Stock</span>
                    </div>
                </div>
            </div>
        </div>

       <?php $cards = Card::find()->map(Card::GET_ONLY_WAREHOUSE); ?>
       <?php /** @var Card $card */
       foreach ($cards as $key => $card) : ?>
           <div class="col-sm-12 col-md-6 col-lg-2 mb-3">
               <div class="card h-100 bg-transparent rounded position-relative">
                   <div class="card-body">
                       <div class="d-flex flex-column gap-1 align-items-center text-center">
                          <?= Html::a('<i class="bi bi-buildings fs-1"></i>', ['stock-per-gudang/view-per-card', 'id' => $key], [
                             'class' => 'stretched-link'
                          ]) ?>
                           <span class="card-title"><?= $card ?></span>
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
       <?php endforeach; ?>


    </div>
</div>