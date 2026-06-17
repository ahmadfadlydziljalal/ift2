<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */


/* @var $model app\models\Stock */
/* @var $this yii\web\View */
/* @see \app\controllers\SiteController::actionScan() */
/* @var $additionalView null|string */

$this->registerCss(<<<CSS
    .scan-card { box-shadow: 0 1px 3px rgba(0,0,0,.06); border: 1px solid rgba(0,0,0,.08); }
    .scan-label { color: #6c757d; font-size: .875rem; }
    .scan-value { font-weight: 600; }
    .scan-divider { border-top: 1px dashed rgba(0,0,0,.1); margin: .75rem 0; }
    .img-frame { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: .5rem; }
    .img-frame img { object-fit: contain; max-height: 420px; width: 100%; }
    CSS
);

// Decode riwayat harga terakhir (maks 5)
$history = [];
if (!empty($model->lastQuotationUnitPricesHistory)) {
    $decoded = json_decode($model->lastQuotationUnitPricesHistory, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $history = $decoded;
    }
}

// Bangun URL ke quotation (jika ada route). Sesuaikan bila route berbeda.
$quotationUrl = static function ($quotationId) {
    if (empty($quotationId)) return null;
    return Url::to(['/quotation/view', 'id' => $quotationId]);
};
?>


<div class="container">
    <div class="stock-scan-view d-flex d-sm-flex-column gap-3 flex-wrap">
        <!-- Image / Preview -->
        <div class="w-25 my-3 my-md-0" style="min-width: 200px;">
            <div class="card scan-card ">
                <div class="card-body">
                    <div class="img-frame ratio ratio-4x3 position-relative">
                        <?php if (empty($model->photoThumbnail)): ?>
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 text-muted">
                                <div class="text-center">
                                    <div class="mb-2">
                                        <i class="bi bi-image" style="font-size:2rem"></i>
                                    </div>
                                    <div>No image available</div>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?= Html::encode($model->photoThumbnail) ?>" target="_blank" title="Buka gambar">
                                <img src="<?= Html::encode($model->photoThumbnail) ?>"
                                     alt="<?= Html::encode($model->namaBarang ?? 'Barang image') ?>" loading="lazy"
                                     class="img-fluid"/>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if ($additionalView): ?>
                <div class="mt-3">
                    <?= $additionalView ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Details -->
        <div class=flex-grow-1">
            <div class="card scan-card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between gap-3">
                        <div>
                            <h5 class="card-title mb-1">
                                <?= Html::encode($model->namaBarang ?? '-') ?>
                            </h5>
                            <div class="text-muted small">ID: <?= Html::encode($model->idBarang ?? '-') ?></div>
                        </div>
                        <?php if (!empty($model->defaultSatuan)): ?>
                            <span class="badge bg-secondary meta-badge align-self-start">U.O.M: <?= Html::encode($model->defaultSatuan) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="scan-divider"></div>

                    <div class="row gy-2">
                        <div class="col-6">
                            <div class="scan-label">Part Number</div>
                            <div class="scan-value">
                                <?= Html::encode($model->partNumber ?? '-') ?>
                                <?php if (!empty($model->partNumber)): ?>
                                    <button class="btn btn-sm btn-outline-secondary ms-2"
                                            onclick="navigator.clipboard.writeText('<?= Html::encode($model->partNumber) ?>')">
                                        Copy
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="scan-label">Kode Barang</div>
                            <div class="scan-value"><?= Html::encode($model->kodeBarang ?? '-') ?></div>
                        </div>
                        <div class="col-6">
                            <div class="scan-label">Merk</div>
                            <div class="scan-value"><?= Html::encode($model->merk ?? '-') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card scan-card mb-3">
                <div class="card-header bg-light py-2">
                    <strong>Informasi Stok</strong>
                </div>
                <div class="card-body">
                    <div class="row gy-3 text-center text-lg-start">
                        <div class="col-6 col-md-3">
                            <div class="scan-label">Stock Awal</div>
                            <div class="scan-value"><?= Yii::$app->formatter->asDecimal($model->stockAwal ?? 0) ?></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="scan-label">Qty Masuk</div>
                            <div class="scan-value text-success"><?= Yii::$app->formatter->asDecimal($model->qtyMasuk ?? 0) ?></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="scan-label">Qty Keluar</div>
                            <div class="scan-value text-danger"><?= Yii::$app->formatter->asDecimal($model->qtyKeluar ?? 0) ?></div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="scan-label">Stock Akhir</div>
                            <div class="scan-value"><?= Yii::$app->formatter->asDecimal($model->stockAkhir ?? 0, 2) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card scan-card">
                <div class="card-header bg-light py-2">
                    <strong>Riwayat Harga Penawaran (5 Terakhir)</strong>
                </div>
                <div class="card-body">
                    <?php if (empty($history)): ?>
                        <div class="text-muted">Belum ada data penawaran.</div>
                    <?php else: ?>
                        <!-- Desktop/Tablet (md and up): table layout -->
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-sm align-middle mb-0">
                                <thead>
                                <tr>
                                    <th class="text-nowrap">Quotation</th>
                                    <th>Customer</th>
                                    <th class="text-end" colspan="2">Unit Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($history as $row): ?>
                                    <tr>
                                        <td class="text-nowrap">
                                            <?php $url = $quotationUrl($row['quotation_id'] ?? null); ?>
                                            <?php if ($url): ?>
                                                <a href="<?= Html::encode($url) ?>" target="_blank"
                                                   class="text-decoration-none">
                                                    <?= Html::encode($row['quotation_nomor'] ?? '-') ?>
                                                </a>
                                            <?php else: ?>
                                                <?= Html::encode($row['quotation_nomor'] ?? '-') ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= Html::encode($row['customer_nama'] ?? '-') ?></td>
                                        <td><?= Html::encode($row['mata_uang'] ?? '-') ?></td>
                                        <td class="text-end fw-semibold text-nowrap">
                                            <?= Yii::$app->formatter->asDecimal($row['unit_price'] ?? 0, 2) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile (sm and down): stacked items -->
                        <div class="d-block d-md-none">
                            <div class="list-group list-group-flush">
                                <?php foreach ($history as $row): ?>
                                    <div class="list-group-item px-0">
                                        <div class="mb-1 small text-muted">Quotation:</div>
                                        <div class="mb-2">
                                            <?php $url = $quotationUrl($row['quotation_id'] ?? null); ?>
                                            <?php if ($url): ?>
                                                <a href="<?= Html::encode($url) ?>" target="_blank"
                                                   class="text-decoration-none fw-semibold">
                                                    <?= Html::encode($row['quotation_nomor'] ?? '-') ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="fw-semibold"><?= Html::encode($row['quotation_nomor'] ?? '-') ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="mb-1 small text-muted">Customer</div>
                                        <div class="mb-2"><?= Html::encode($row['customer_nama'] ?? '-') ?></div>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="small text-muted">Unit Price</div>
                                            <div class="fw-semibold text-nowrap">
                                                <?= Html::encode($row['mata_uang'] ?? '-') ?>
                                                <?= Yii::$app->formatter->asDecimal($row['unit_price'] ?? 0, 2) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>



