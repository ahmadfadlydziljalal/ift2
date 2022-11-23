<?php

/* @var $this View */

/* @var $model Quotation */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\helpers\Html;
use yii\web\View;

?>

<div class="quotation-item">
    <div class="card border-0 shadow rounded">
        <div class="card-body">

            <div class="d-flex flex-row flex-wrap align-items-center">
                <div class="master border-end pe-3" style="min-width: 22rem">
                    <p>
                        <?= $model->customer->nama ?> <br/>
                        <?= $model->nomor ?>
                    </p>


                    <small class="text-muted">
                        Valid dari <?= Yii::$app->formatter->asDate($model->tanggal) ?>
                        s/d <?= Yii::$app->formatter->asDate($model->tanggal_batas_valid) ?> <br/>
                    </small>
                </div>

                <div class="detail align-self-center ps-3 flex-grow-1 d-block d-sm-none d-md-block d-lg-block border-end pe-1">

                    <div class="row w-100">
                        <div class="col">
                            <p class="text-muted">Barang's Quotation</p>
                            <h5><?= $model->mataUang->singkatan ?> <?= Yii::$app->formatter->asDecimal($model->quotationBarangsTotal, 2) ?></h5>

                            <?php if (empty($model->quotationBarangs)) : ?>

                                <?php /* @see \app\controllers\QuotationController::actionCreateBarangQuotation() */ ?>
                                <?= Html::a('<i class="bi bi-plus-lg"></i>', ['quotation/create-barang-quotation', 'id' => $model->id], ['class' => 'text-primary']) ?>

                            <?php else : ?>

                                <?php /* @see \app\controllers\QuotationController::actionUpdateBarangQuotation() */ ?>
                                <?= Html::a('<i class="bi bi-pen-fill"></i>', ['quotation/update-barang-quotation', 'id' => $model->id], ['class' => 'text-primary']) ?>

                                <?php /* @see \app\controllers\QuotationController::actionDeleteBarangQuotation() */ ?>
                                <?= Html::a('<i class="bi bi-trash-fill"></i>', ['quotation/delete-barang-quotation', 'id' => $model->id], [
                                    'class' => 'text-primary',
                                    'data' => [
                                        'confirm' => 'Apakah anda yakin menghapus barang quotation ini ?',
                                        'method' => 'post'
                                    ]
                                ]) ?>
                            <?php endif; ?>
                        </div>
                        <div class="col">
                            <p class="text-muted">
                                Services Quotation
                            </p>
                            <h5><?= $model->mataUang->singkatan ?> <?= Yii::$app->formatter->asDecimal($model->quotationServicesTotal, 2) ?></h5>

                            <?php if (empty($model->quotationServices)) : ?>

                                <?= Html::a('<i class="bi bi-plus-lg"></i>', ['quotation/create-service-quotation', 'id' => $model->id], ['class' => 'text-primary']) ?>

                            <?php else: ?>

                                <?php /* @see \app\controllers\QuotationController::actionUpdateServiceQuotation() */ ?>
                                <?= Html::a('<i class="bi bi-pen-fill"></i>', ['quotation/update-service-quotation', 'id' => $model->id], ['class' => 'text-primary']) ?>

                                <?php /* @see \app\controllers\QuotationController::actionDeleteServiceQuotation() */ ?>
                                <?= Html::a('<i class="bi bi-trash-fill"></i>', ['quotation/delete-service-quotation', 'id' => $model->id], [
                                    'class' => 'text-primary',
                                    'data' => [
                                        'confirm' => 'Apakah anda yakin menghapus service quotation ini ?',
                                        'method' => 'post'
                                    ]
                                ]) ?>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <div class="ms-auto ps-3 text-end">
                    <?= Html::a(TextLinkEnum::VIEW->value, ['quotation/view', 'id' => $model->id], [
                        'class' => 'text-decoration-none'
                    ]) ?>
                    <?= Html::a(TextLinkEnum::UPDATE->value, ['quotation/update', 'id' => $model->id], [
                        'class' => 'text-decoration-none'
                    ]) ?>
                    <?= Html::a(TextLinkEnum::DELETE->value, ['quotation/delete', 'id' => $model->id], [
                        'class' => 'text-decoration-none text-danger',
                        'data' => [
                            'confirm' => 'Apakah anda yakin menghapus service quotation ini ?',
                            'method' => 'post'
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>