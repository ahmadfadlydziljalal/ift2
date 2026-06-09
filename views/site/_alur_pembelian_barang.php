<?php

/* @var $this View */

use yii\bootstrap5\Html;
use yii\web\View;

// Hover lift + transition untuk a.card sekarang di-handle oleh _card.scss.
// Tidak perlu registerCss di sini.

$steps = [
    [
        'num'   => 1,
        'icon'  => 'bi-bag',
        'label' => 'Material Requisition',
        'url'   => ['material-requisition/index'],
        'color' => 'primary',
    ],
    [
        'num'   => 2,
        'icon'  => 'bi-aspect-ratio',
        'label' => 'Penawaran',
        'url'   => null,            // belum ada halaman khusus
        'color' => 'secondary',
    ],
    [
        'num'   => 3,
        'icon'  => 'bi-truck',
        'label' => 'Purchase Order',
        'url'   => ['purchase-order/index'],
        'color' => 'info',
    ],
    [
        'num'   => 4,
        'icon'  => 'bi-bag-check-fill',
        'label' => 'Terima Barang',
        'url'   => ['tanda-terima-barang/index'],
        'color' => 'warning',
    ],
    [
        'num'   => 5,
        'icon'  => 'bi-flag-fill',
        'label' => 'Laporan Incoming',
        'url'   => ['tanda-terima-barang/laporan-incoming'],
        'color' => 'success',
    ],
    [
        'num'   => 6,
        'icon'  => 'bi-wallet-fill',
        'label' => 'Stock In',
        'url'   => ['stock/index'],
        'color' => 'success',
    ],
];
?>

<div class="alur-pembelian-barang mb-2">

    <!-- Section heading -------------------------------------------------->
    <div class="d-flex align-items-center gap-3 mb-3">
        <!-- Bootstrap 5.2: bg-opacity-10 + bg-primary + rounded-2 -->
        <span class="bg-primary bg-opacity-10 text-primary rounded-2 p-2 d-inline-flex lh-1">
            <i class="bi bi-cart-check-fill fs-1"></i>
        </span>
        <div>
            <p class="text-uppercase text-muted fw-bold mb-0" style="font-size:.65rem;letter-spacing:.08em">Alur
                Kerja</p>
            <h6 class=" fw-bold mb-0">Pembelian Barang</h6>
        </div>
    </div>

    <!-- Steps row: d-flex overflow-auto → horizontal scroll on small screens -->
    <div class="d-flex overflow-auto pb-2 pt-1 gap-3 align-items-stretch">

        <?php foreach ($steps as $i => $step): ?>

            <?php if ($i > 0): ?>
                <!-- Connector: Bootstrap d-flex + text-muted + opacity-50 -->
                <div class="d-flex align-items-center justify-content-center flex-shrink-0 text-muted opacity-50 px-1">
                    <i class="bi bi-chevron-right small"></i>
                </div>
            <?php endif; ?>

            <!-- Step wrapper: fixed width so cards stay same size -->
            <div class="flex-shrink-0" style="width:115px">
                <?php
                // Badge step-number: badge + rounded-circle + bg-{color}
                // width/height inline karena Bootstrap tidak punya utility ukuran spesifik untuk circle badge
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

                // card-accent-{color} dari _card.scss menangani border-top berwarna.
                // border-0 menghapus default card border; shadow + radius dari _card.scss.
                $cardClass = 'card card-accent-' . $step['color']
                    . ' border-0 shadow-sm h-100 p-3'
                    . ' d-flex flex-column align-items-center justify-content-center'
                    . ' text-center gap-2 text-decoration-none';
                ?>

                <?php if ($step['url']): ?>
                    <?= Html::a($inner, $step['url'], [
                        'class' => $cardClass,
                    ]) ?>
                <?php else: ?>
                    <!-- Tidak ada link: opacity-75 menandakan step non-interaktif -->
                    <div class="<?= $cardClass ?> opacity-75">
                        <?= $inner ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>

    </div>

</div>