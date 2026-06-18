<?php

/* @var $this yii\web\View */
/* @var $model app\models\Quotation|string|yii\db\ActiveRecord */
?>


<div class="d-flex flex-column">
    <!-- Row 1: No Service | Customer -->
    <div class="row gy-2 mb-2">
        <div class="col-12 col-lg-6">
            <!-- Large+: inline -->
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">No. Service</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= $model->quotationFormJob?->getNomorDisplay() ?></div>
                </div>
            </div>
            <!-- Medium & Small: stacked -->
            <div class="d-lg-none">
                <div class="small text-muted">No Service:</div>
                <div><?= $model->quotationFormJob?->getNomorDisplay() ?></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">Customer</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= $model->customer->nama ?></div>
                </div>
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
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">No SPK</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= $model->quotationFormJob?->getNomorSuratPerintahKerja() ?></div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="small text-muted">No SPK:</div>
                <div><?= $model->quotationFormJob?->getNomorSuratPerintahKerja() ?></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">No Unit</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate">
                        <?= empty($model->quotationFormJob?->cardOwnEquipment)
                            ? $model->quotationFormJob?->cardOwnEquipment?->nomor_unit
                            : 'Empty No Unit' ?></div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="small text-muted">No Unit:</div>
                <div><?= empty($model->quotationFormJob?->cardOwnEquipment)
                        ? $model->quotationFormJob?->cardOwnEquipment?->nomor_unit
                        : 'Empty No Unit' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: No Quotation | Merk/Type -->
    <div class="row gy-2 mb-2">
        <div class="col-12 col-lg-6">
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">No Quotation</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= $model->nomor ?></div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="small text-muted">No Quotation:</div>
                <div><?= $model->nomor ?></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">Merk/Type</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= empty($model->quotationFormJob?->cardOwnEquipment) ? $model->quotationFormJob?->cardOwnEquipment?->merk : 'No Merk' ?>
                        / <?= $model->quotationFormJob?->cardOwnEquipment?->nama ?></div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="small text-muted">Merk/Type:</div>
                <div><?= empty($model->quotationFormJob?->cardOwnEquipment) ? $model->quotationFormJob?->cardOwnEquipment?->merk : 'No Merk' ?>
                    / <?= $model->quotationFormJob?->cardOwnEquipment?->nama ?></div>
            </div>
        </div>
    </div>

    <!-- Row 4: Date | H/M -->
    <div class="row gy-2 mb-2">
        <div class="col-12 col-lg-6">
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">Date</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= Yii::$app->formatter->asDate($model->tanggal, 'php: d-M-Y') ?></div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="small text-muted">Date:</div>
                <div><?= Yii::$app->formatter->asDate($model->tanggal, 'php: d-M-Y') ?></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">H/M</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= $model->quotationFormJob?->hour_meter ?></div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="small text-muted">H/M:</div>
                <div><?= $model->quotationFormJob?->hour_meter ?></div>
            </div>
        </div>
    </div>

    <!-- Row 5: PIC | Production No -->
    <div class="row gy-2 mb-2">
        <div class="col-12 col-lg-6">
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">PIC</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= $model->quotationFormJob?->person_in_charge ?></div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="small text-muted">PIC:</div>
                <div><?= $model->quotationFormJob?->person_in_charge ?></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">Production No</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= $model->quotationFormJob?->cardOwnEquipment?->serial_number ?></div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="small text-muted">Production No:</div>
                <div><?= $model->quotationFormJob?->cardOwnEquipment?->serial_number ?></div>
            </div>
        </div>
    </div>

    <!-- Row 6: Issue | Mekanik -->
    <div class="row gy-2 mb-2">
        <div class="col-12 col-lg-6">
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">Issue</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= $model->quotationFormJob?->issue ?></div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="small text-muted">Issue:</div>
                <div><?= $model->quotationFormJob?->issue ?></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="d-none d-lg-block">
                <div class="row gx-2 align-items-baseline">
                    <div class="col-auto text-nowrap fw-bold">Mekanik</div>
                    <div class="col-auto">:</div>
                    <div class="col text-truncate"><?= !empty($model->quotationFormJob?->namaMekaniks) ? implode(";", $model->quotationFormJob?->namaMekaniks) : '' ?></div>
                </div>
            </div>
            <div class="d-lg-none">
                <div class="small text-muted">Mekanik:</div>
                <div><?= !empty($model->quotationFormJob?->namaMekaniks) ? implode(";", $model->quotationFormJob?->namaMekaniks) : '' ?></div>
            </div>
        </div>
    </div>
</div>