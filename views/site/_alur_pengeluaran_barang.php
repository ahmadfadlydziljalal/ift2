<?php

/* @var $this View */

use yii\bootstrap5\Html;
use yii\web\View;

$steps = [
    [
        'num'   => 1,
        'icon'  => 'bi-body-text',
        'label' => 'Quotation',
        'url'   => ['quotation/index'],
        'color' => 'primary',
    ],
    [
        'num'   => 2,
        'icon'  => 'bi-aspect-ratio',
        'label' => 'Delivery Receipt',
        'url'   => null,            // belum ada halaman khusus
        'color' => 'secondary',
    ],
    [
        'num'   => 3,
        'icon'  => 'bi-flag-fill',
        'label' => 'Laporan Outgoing',
        'url'   => ['quotation/laporan-outgoing'],
        'color' => 'success',
    ],
];
?>

<div class="alur-pengeluaran-barang mb-2">

    <!-- Section heading -->
    <div class="d-flex align-items-center gap-3 mb-3">
        <span class="bg-warning bg-opacity-10 text-warning rounded-2 p-2 d-inline-flex lh-1">
            <i class="bi bi-box-seam-fill fs-1"></i>
        </span>
        <div>
            <p class="text-uppercase text-muted fw-bold mb-0" style="font-size:.65rem;letter-spacing:.08em">Alur
                Kerja</p>
            <h6 class="fw-bold mb-0">Pengeluaran Barang</h6>
        </div>
    </div>

    <!-- Steps row: horizontal scroll -->
    <div class="d-flex overflow-auto pb-2 pt-1 gap-3 align-items-stretch">

        <?php foreach ($steps as $i => $step): ?>

            <?php if ($i > 0): ?>
                <div class="d-flex align-items-center justify-content-center flex-shrink-0 text-muted opacity-50 px-1">
                    <i class="bi bi-chevron-right small"></i>
                </div>
            <?php endif; ?>

            <div class="flex-shrink-0" style="width:115px">
                <?php
                $numBadge =
                    '<span class="badge bg-' . $step['color'] . ' rounded-circle'
                    . ' d-inline-flex align-items-center justify-content-center fw-bold"'
                    . ' style="width:1.5rem;height:1.5rem;font-size:.65rem">'
                    . $step['num']
                    . '</span>';

                $inner =
                    $numBadge
                    . '<i class="bi ' . $step['icon'] . ' text-' . $step['color'] . ' fs-2"></i>'
                    . '<span class="small lh-sm text-body">'
                    . Html::encode($step['label'])
                    . '</span>';

                $cardClass = 'card card-accent-' . $step['color']
                    . ' border-0 shadow-sm h-100 p-3'
                    . ' d-flex flex-column align-items-center justify-content-center'
                    . ' text-center gap-2 text-decoration-none';
                ?>

                <?php if ($step['url']): ?>
                    <?= Html::a($inner, $step['url'], ['class' => $cardClass]) ?>
                <?php else: ?>
                    <div class="<?= $cardClass ?> opacity-75">
                        <?= $inner ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>

    </div>

</div>