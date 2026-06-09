<?php

/* @var $this View */

use app\models\Card;
use yii\bootstrap5\Html;
use yii\web\View;

$warehouses = Card::find()->map(Card::GET_ONLY_WAREHOUSE);
?>

<div class="site-stock mb-2">

    <!-- Section heading -->
    <div class="d-flex align-items-center gap-3 mb-3">
        <span class="bg-info bg-opacity-10 text-info rounded-2 p-2 d-inline-flex lh-1">
            <i class="bi bi-boxes fs-1"></i>
        </span>
        <div>
            <p class="text-uppercase text-muted fw-bold mb-0" style="font-size:.65rem;letter-spacing:.08em">
                Inventori</p>
            <h6 class="fw-bold mb-0">Stock</h6>
        </div>
    </div>

    <!-- Cards row: horizontal scroll, no connectors (bukan sequential flow) -->
    <div class="d-flex overflow-auto pb-2 pt-1 gap-3 align-items-stretch">

        <!-- All Stock -->
        <div class="flex-shrink-0" style="width:115px">
            <?= Html::a(
                '<i class="bi bi-body-text text-primary fs-2"></i>'
                . '<span class="small lh-sm text-body">All Stock</span>',
                ['stock/index'],
                [
                    'class' => 'card card-accent-primary border-0 shadow-sm h-100 p-3'
                        . ' d-flex flex-column align-items-center justify-content-center'
                        . ' text-center gap-2 text-decoration-none',
                ]
            ) ?>
        </div>

        <!-- Per-warehouse cards -->
        <?php foreach ($warehouses as $id => $nama): ?>
            <div class="flex-shrink-0" style="width:115px">
                <?= Html::a(
                    '<i class="bi bi-buildings text-info fs-2"></i>'
                    . '<span class="small lh-sm text-body">' . Html::encode($nama) . '</span>',
                    ['stock-per-gudang/view-per-card', 'id' => $id],
                    [
                        'class' => 'card card-accent-info border-0 shadow-sm h-100 p-3'
                            . ' d-flex flex-column align-items-center justify-content-center'
                            . ' text-center gap-2 text-decoration-none',
                    ]
                ) ?>
            </div>
        <?php endforeach; ?>

    </div>

</div>