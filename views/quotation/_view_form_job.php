<?php

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model Quotation|string|ActiveRecord */
/* @see \app\controllers\QuotationController::actionCreateFormJob() */
/* @see \app\controllers\QuotationController::actionUpdateFormJob() */
/* @see \app\controllers\QuotationController::actionDeleteFormJob() */
/* @see \app\controllers\QuotationController::actionDeleteFormJobType */
?>

<?php
$this->registerCss(<<<CSS
/* Align label-colon-value in columns on lg+ */
@media (min-width: 992px){
  #form-job .kv-line{
    display:grid;
    grid-template-columns: 12ch auto 1fr;
    column-gap: .5rem;
    align-items: baseline;
  }
  #form-job .kv-line > .kv-value{ min-width:0; }
}
@media (max-width: 576px){
  #form-job .x-scroll-sm { overflow-x: auto; -webkit-overflow-scrolling: touch; }
  #form-job .x-scroll-sm .row { flex-wrap: nowrap; }
}
CSS
);
?>
<div id="form-job">
    <div class="d-flex flex-column gap-3">
        <div class="d-flex flex-row gap-2">
            <h3>Form Job</h3>
            <div class="ms-auto">
                <?php if (!$model->quotationFormJob) : ?>

                    <?= Html::a(TextLinkEnum::TAMBAH->value, ['quotation/create-form-job', 'id' => $model->id], [
                        'class' => 'btn btn-outline-success'
                    ]) ?>

                <?php else : ?>

                    <?= Html::a(TextLinkEnum::PRINT->value, ['quotation/print-form-job', 'id' => $model->id], [
                        'class'  => 'btn btn-outline-success',
                        'target' => '_blank',
                        'rel'    => 'noopener noreferrer'
                    ]) ?>

                    <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update-form-job', 'id' => $model->id], [
                        'class' => 'btn btn-outline-primary'
                    ]) ?>

                    <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete-form-job', 'id' => $model->id], [
                        'class'        => 'btn btn-outline-danger',
                        'data-method'  => 'post',
                        'data-confirm' => 'Apakah Anda akan menghapus detail quotation barang ini ?'
                    ]) ?>

                <?php endif; ?>
            </div>
        </div>

        <?php if ($model->quotationFormJob) : ?>
            <div class="d-flex flex-column">
                <!-- Row 1: No Service | Customer -->
                <div class="row gy-2 mb-2">
                    <div class="col-12 col-lg-6">
                        <!-- Large+: inline -->
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">No Service</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= $model->quotationFormJob->getNomorDisplay() ?></span>
                        </div>
                        <!-- Medium & Small: stacked -->
                        <div class="d-lg-none">
                            <div class="small text-muted">No Service:</div>
                            <div><?= $model->quotationFormJob->getNomorDisplay() ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">Customer</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= $model->customer->nama ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">Customer:</div>
                            <div><?= $model->customer->nama ?></div>
                        </div>
                    </div>
                </div>

                <!-- Row 2: No SPK | No Unit -->
                <div class="row gy-2 mb-2">
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">No SPK</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= $model->quotationFormJob->getNomorSuratPerintahKerja() ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">No SPK:</div>
                            <div><?= $model->quotationFormJob->getNomorSuratPerintahKerja() ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">No Unit</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= empty($model->quotationFormJob->cardOwnEquipment) ? $model->quotationFormJob->cardOwnEquipment?->nomor_unit : 'Empty No Unit' ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">No Unit:</div>
                            <div><?= empty($model->quotationFormJob->cardOwnEquipment) ? $model->quotationFormJob->cardOwnEquipment?->nomor_unit : 'Empty No Unit' ?></div>
                        </div>
                    </div>
                </div>

                <!-- Row 3: No Quotation | Merk/Type -->
                <div class="row gy-2 mb-2">
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">No Quotation</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= $model->nomor ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">No Quotation:</div>
                            <div><?= $model->nomor ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">Merk/Type</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= empty($model->quotationFormJob->cardOwnEquipment) ? $model->quotationFormJob->cardOwnEquipment?->merk : 'No Merk' ?> / <?= $model->quotationFormJob->cardOwnEquipment?->nama ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">Merk/Type:</div>
                            <div><?= empty($model->quotationFormJob->cardOwnEquipment) ? $model->quotationFormJob->cardOwnEquipment?->merk : 'No Merk' ?>
                                / <?= $model->quotationFormJob->cardOwnEquipment?->nama ?></div>
                        </div>
                    </div>
                </div>

                <!-- Row 4: Date | H/M -->
                <div class="row gy-2 mb-2">
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">Date</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= Yii::$app->formatter->asDate($model->tanggal, 'php: d-M-Y') ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">Date:</div>
                            <div><?= Yii::$app->formatter->asDate($model->tanggal, 'php: d-M-Y') ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">H/M</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= $model->quotationFormJob->hour_meter ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">H/M:</div>
                            <div><?= $model->quotationFormJob->hour_meter ?></div>
                        </div>
                    </div>
                </div>

                <!-- Row 5: PIC | Production No -->
                <div class="row gy-2 mb-2">
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">PIC</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= $model->quotationFormJob->person_in_charge ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">PIC:</div>
                            <div><?= $model->quotationFormJob->person_in_charge ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">Production No</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= $model->quotationFormJob->cardOwnEquipment?->serial_number ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">Production No:</div>
                            <div><?= $model->quotationFormJob->cardOwnEquipment?->serial_number ?></div>
                        </div>
                    </div>
                </div>

                <!-- Row 6: Issue | Mekanik -->
                <div class="row gy-2 mb-2">
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">Issue</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= $model->quotationFormJob->issue ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">Issue:</div>
                            <div><?= $model->quotationFormJob->issue ?></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="d-none d-lg-grid kv-line">
                            <span class="text-nowrap">Mekanik</span>
                            <span>:</span>
                            <span class="kv-value text-truncate"><?= implode(";", $model->quotationFormJob->namaMekaniks) ?></span>
                        </div>
                        <div class="d-lg-none">
                            <div class="small text-muted">Mekanik:</div>
                            <div><?= implode(";", $model->quotationFormJob->namaMekaniks) ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <?= $this->render('_view_form_job_jobs_and_spare_part', ['model' => $model]) ?>
            <hr/>
            <div class="row row-cols-1 mb-2">
                <div class="col">
                    <p>Remarks</p>
                    <?= !empty($model->quotationFormJob->remarks) ? nl2br($model->quotationFormJob->remarks) : 'No Remarks!' ?>
                </div>
            </div>
        <?php else : ?>
            <p class="text-danger fw-bold">Belum ada form job</p>
        <?php endif; ?>

    </div>
</div>