<?php

/* @var $this View */

/* @var $model Quotation */

use app\models\Quotation;
use yii\helpers\Html;
use yii\web\View;

?>

<div class="quotation-item">

    <div class="border p-3">
        <div class="mb-3">
            <div class="d-flex justify-content-between flex-wrap">
                <span><i class="bi bi-arrow-right-circle"></i> <?= $model->nomor ?></span>
                <span><i class="bi bi-person-badge"></i> <?= $model->customer->nama ?></span>

            </div>
        </div>

        <div class="row ">
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-3 mb-sm-3 mb-md-3 mb-lg-1">
                <div class="card bg-transparent border  h-100 w-100">
                    <div class="card-body">
                        <small class="text-muted">
                            Valid dari <br/><?= Yii::$app->formatter->asDate($model->tanggal) ?> s/d <br/>
                           <?= Yii::$app->formatter->asDate($model->tanggal_batas_valid) ?> <br/>
                        </small>
                    </div>
                    <div class="card-footer p-3">

                       <?= Html::a('<i class="bi bi-eye"></i>', ['quotation/view', 'id' => $model->id], [
                          'class' => 'btn btn-primary'
                       ]) ?>
                       <?= Html::a('<i class="bi bi-pen-fill"></i>', ['quotation/update', 'id' => $model->id], [
                          'class' => 'btn btn-primary'
                       ]) ?>
                       <?= Html::a('<i class="bi bi-trash"></i>', ['quotation/delete', 'id' => $model->id], [
                          'class' => 'btn btn-danger',
                          'data' => [
                             'confirm' => 'Apakah anda yakin menghapus service quotation ini ?',
                             'method' => 'post'
                          ]
                       ]) ?>

                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-3 mb-lg-1">
                <div class="card bg-transparent border  h-100 w-100">
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
                             'class' => 'text-danger',
                             'data' => [
                                'confirm' => 'Apakah anda yakin menghapus barang quotation ini ?',
                                'method' => 'post'
                             ]
                          ]) ?>
                       <?php endif; ?>
                    </div>
                </div>

            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-3 mb-lg-1">
                <div class="card bg-transparent border  h-100 w-100">
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

                       <?php else : ?>

                          <?php /* @see \app\controllers\QuotationController::actionUpdateServiceQuotation() */ ?>
                          <?= Html::a('<i class="bi bi-pen-fill"></i>', ['quotation/update-service-quotation', 'id' => $model->id], ['class' => 'text-primary']) ?>

                          <?php /* @see \app\controllers\QuotationController::actionDeleteServiceQuotation() */ ?>
                          <?= Html::a('<i class="bi bi-trash-fill"></i>', ['quotation/delete-service-quotation', 'id' => $model->id], [
                             'class' => 'text-danger',
                             'data' => [
                                'confirm' => 'Apakah anda yakin menghapus service quotation ini ?',
                                'method' => 'post'
                             ]
                          ]) ?>

                       <?php endif; ?>
                    </div>

                </div>

            </div>
            <!--            <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-3 mb-lg-1">-->
            <!--                <div class="card bg-transparent border  h-100 w-100">-->
            <!--                    <div class="card-body">-->
            <!--                        <div class="d-flex flex-column gap-1">-->
            <!--                            <div>-->
            <!--                                <p class="text-muted text-nowrap">Term & Condition</p>-->
            <!--                            </div>-->
            <!--                            <div>-->
            <!--                                <strong>-->
           <?php //echo  count($model->quotationTermAndConditions) ?><!--</strong>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!---->
            <!--                    <div class="card-footer p-3">-->
            <!--                       --><?php //if (empty($model->quotationTermAndConditions)) : ?>
            <!---->
            <!--                          --><?php //echo  Html::a('<i class="bi bi-plus-lg"></i>', ['quotation/create-term-and-condition', 'id' => $model->id], ['class' => 'text-primary']) ?>
            <!---->
            <!--                       --><?php //else : ?>
            <!---->
            <!--                          --><?php ///* @see \app\controllers\QuotationController::actionUpdateServiceQuotation() */ ?>
            <!--                          --><?php //echo  Html::a('<i class="bi bi-pen-fill"></i>', ['quotation/update-term-and-condition', 'id' => $model->id], ['class' => 'text-primary']) ?>
            <!---->
            <!--                          --><?php ///* @see \app\controllers\QuotationController::actionDeleteServiceQuotation() */ ?>
            <!--                          --><?php //echo  Html::a('<i class="bi bi-trash-fill"></i>', ['quotation/delete-term-and-condition', 'id' => $model->id], [
           //                             'class' => 'text-danger',
           //                             'data' => [
           //                                'confirm' => 'Apakah anda yakin menghapus term and condition quotation ini ?',
           //                                'method' => 'post'
           //                             ]
           //                          ]) ?>
            <!---->
            <!--                       --><?php //endif; ?>
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-3 mb-lg-1">
                <div class="card bg-transparent border  h-100 w-100">
                    <div class="card-body">
                        <div class="d-flex flex-column gap-1">
                            <div>
                                <span class="text-muted">Form Job</span>
                            </div>
                            <div>
                                <strong><?= !empty($model->quotationFormJob) ? $model->quotationFormJob->getNomorDisplay() : "" ?></strong>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer p-3">

                       <?php if (empty($model->quotationFormJob)) : ?>

                          <?= Html::a('<i class="bi bi-plus-lg"></i>', ['quotation/create-form-job', 'id' => $model->id], ['class' => 'text-primary']) ?>

                       <?php else : ?>

                          <?php /* @see \app\controllers\QuotationController::actionUpdateServiceQuotation() */ ?>
                          <?= Html::a('<i class="bi bi-pen-fill"></i>', ['quotation/update-form-job', 'id' => $model->id], ['class' => 'text-primary']) ?>

                          <?php /* @see \app\controllers\QuotationController::actionDeleteServiceQuotation() */ ?>
                          <?= Html::a('<i class="bi bi-trash-fill"></i>', ['quotation/delete-form-job', 'id' => $model->id], [
                             'class' => 'text-danger',
                             'data' => [
                                'confirm' => 'Apakah anda yakin menghapus term and condition quotation ini ?',
                                'method' => 'post'
                             ]
                          ]) ?>
                       <?php endif; ?>

                    </div>

                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-2 mb-3 mb-sm-3 mb-md-3 mb-lg-1">
                <div class="card bg-transparent border h-100 w-100">
                    <div class="card-body">
                        <div class="d-flex flex-column gap-1">
                            <div>
                                <span class="text-muted">Delivery Receipt</span>
                            </div>
                            <div>
                               <?php if (!empty($model->quotationDeliveryReceipts)) : ?>

                                  <?php foreach ($model->quotationDeliveryReceipts as $quotationDeliveryReceipt): ?>

                                       <strong><?= $quotationDeliveryReceipt->getNomorDisplay() . ';' ?></strong>
                                  <?php endforeach; ?>

                               <?php endif; ?>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer p-3">
                       <?= Html::a('<i class="bi bi-plus-lg"></i>', ['quotation/create-delivery-receipt', 'id' => $model->id], ['class' => 'text-primary']) ?>
                       <?php /* @see \app\controllers\QuotationController::actionDeleteServiceQuotation() */ ?>
                       <?= Html::a('<i class="bi bi-trash-fill"></i>', ['quotation/delete-delivery-receipt', 'id' => $model->id], [
                          'class' => 'text-danger',
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