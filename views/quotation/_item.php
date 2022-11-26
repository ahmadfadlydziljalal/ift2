<?php

/* @var $this View */

/* @var $model Quotation */

use app\components\helpers\ArrayHelper;
use app\enums\TextLinkEnum;
use app\models\Quotation;
use yii\helpers\Html;
use yii\web\View;

?>

<div class="quotation-item">
    <div class="card border-0 shadow rounded">

        <div class="card-header border-bottom d-flex justify-content-between flex-wrap align-items-baseline">
            <div>
                <span class="badge bg-primary"><?= $model->nomor ?></span> | <span
                        class="badge bg-danger"><?= $model->customer->nama ?></span>
            </div>
            <div>
                <div class="d-flex flex-row gap-3">
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

        <div class="card-body">
            <div class="row ">

                <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-0">

                    <div class="border rounded h-100 w-100 p-3">
                        <small class="text-muted">
                            Valid dari <br/><?= Yii::$app->formatter->asDate($model->tanggal) ?>
                            s/d <?= Yii::$app->formatter->asDate($model->tanggal_batas_valid) ?> <br/>
                        </small>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-0">


                    <div class="card border shadow-sm rounded h-100 w-100">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-1">
                                <div>
                                    <span class="text-muted">Barang</span>
                                </div>
                                <div>
                                    <strong><?= $model->mataUang->singkatan ?> <?= Yii::$app->formatter->asDecimal($model->quotationBarangsTotal, 2) ?></strong>

                                </div>

                            </div>
                        </div>

                        <div class="card-footer p-3">
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
                    </div>

                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-0">
                    <div class="card border shadow-sm rounded h-100 w-100">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-1">
                                <div>
                                    <span class="text-muted">Services</span>
                                </div>
                                <div>
                                    <strong><?= $model->mataUang->singkatan ?> <?= Yii::$app->formatter->asDecimal($model->quotationServicesTotal, 2) ?></strong>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer p-3">
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

                <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-0">
                    <div class="card border shadow-sm rounded h-100 w-100">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-1">
                                <div>
                                    <p class="text-muted text-nowrap">Term & Condition</p>
                                </div>
                                <div>
                                    <strong><?= count($model->quotationTermAndConditions) ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer p-3">
                           <?php if (empty($model->quotationTermAndConditions)) : ?>

                              <?= Html::a('<i class="bi bi-plus-lg"></i>', ['quotation/create-term-and-condition', 'id' => $model->id], ['class' => 'text-primary']) ?>

                           <?php else: ?>

                              <?php /* @see \app\controllers\QuotationController::actionUpdateServiceQuotation() */ ?>
                              <?= Html::a('<i class="bi bi-pen-fill"></i>', ['quotation/update-term-and-condition', 'id' => $model->id], ['class' => 'text-primary']) ?>

                              <?php /* @see \app\controllers\QuotationController::actionDeleteServiceQuotation() */ ?>
                              <?= Html::a('<i class="bi bi-trash-fill"></i>', ['quotation/delete-term-and-condition', 'id' => $model->id], [
                                 'class' => 'text-primary',
                                 'data' => [
                                    'confirm' => 'Apakah anda yakin menghapus term and condition quotation ini ?',
                                    'method' => 'post'
                                 ]
                              ]) ?>

                           <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-0">
                    <div class="card border shadow-sm rounded h-100 w-100">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-1">
                                <div>
                                    <span class="text-muted">Form Job</span>
                                </div>
                                <div>
                                    <strong><?= !empty($model->quotationFormJob) ? $model->quotationFormJob->nomor : "" ?></strong>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer p-3">

                           <?php if (empty($model->quotationFormJob)) : ?>

                              <?= Html::a('<i class="bi bi-plus-lg"></i>', ['quotation/create-form-job', 'id' => $model->id], ['class' => 'text-primary']) ?>

                           <?php else: ?>

                              <?php /* @see \app\controllers\QuotationController::actionUpdateServiceQuotation() */ ?>
                              <?= Html::a('<i class="bi bi-pen-fill"></i>', ['quotation/update-form-job', 'id' => $model->id], ['class' => 'text-primary']) ?>

                              <?php /* @see \app\controllers\QuotationController::actionDeleteServiceQuotation() */ ?>
                              <?= Html::a('<i class="bi bi-trash-fill"></i>', ['quotation/delete-form-job', 'id' => $model->id], [
                                 'class' => 'text-primary',
                                 'data' => [
                                    'confirm' => 'Apakah anda yakin menghapus term and condition quotation ini ?',
                                    'method' => 'post'
                                 ]
                              ]) ?>
                           <?php endif; ?>

                        </div>

                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-0">
                    <div class="card border shadow-sm rounded h-100 w-100">
                        <div class="card-body">
                            <div class="d-flex flex-column gap-1">
                                <div>
                                    <span class="text-muted">Delivery Receipt</span>
                                </div>
                                <div>
                                   <?php if (!empty($model->quotationDeliveryReceipts)) : ?>
                                       <strong><?= implode("; ", ArrayHelper::getColumn(ArrayHelper::toArray($model->quotationDeliveryReceipts), 'nomor')) ?></strong>
                                   <?php endif; ?>
                                </div>

                            </div>

                        </div>

                        <div class="card-footer p-3">
                           <?= Html::a('<i class="bi bi-plus-lg"></i>', ['quotation/create-delivery-receipt', 'id' => $model->id], ['class' => 'text-primary']) ?>
                           <?php /* @see \app\controllers\QuotationController::actionDeleteServiceQuotation() */ ?>
                           <?= Html::a('<i class="bi bi-trash-fill"></i>', ['quotation/delete-delivery-receipt', 'id' => $model->id], [
                              'class' => 'text-primary',
                              'data' => [
                                 'confirm' => 'Apakah anda yakin menghapus term and condition quotation ini ?',
                                 'method' => 'post'
                              ]
                           ]) ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>