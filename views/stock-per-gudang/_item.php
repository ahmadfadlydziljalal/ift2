<?php
/** @var yii\web\View $this */

/** @var Card $model */

use app\models\Card;
use yii\helpers\Html;

?>
<div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-3">
    <div class="card bg-transparent rounded  ">

        <div class="card-body d-flex flex-column align-items-center justify-content-center text-center gap-3"
             style="height: 12em">
            <i class="bi bi-building-check fs-1"></i>
            <h2>
               <?= Html::a($model->nama, ['stock-per-gudang/view-per-card', 'id' => $model->id], [
                  'class' => 'stretched-link text-decoration-none'
               ]) ?>
            </h2>
        </div>
    </div>
</div>