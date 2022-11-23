<?php

use app\enums\TextLinkEnum;
use mdm\admin\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Quotation */
/* @see app\controllers\QuotationController::actionView() */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="quotation-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="d-flex flex-row gap-2 mb-3">
        <?= Html::a(TextLinkEnum::KEMBALI->value, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a(TextLinkEnum::PRINT->value, ['print', 'id' => $model->id], [
            'class' => 'btn btn-outline-success',
            'target' => '_blank',
            'rel' => 'noopener noreferrer'
        ]) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        <?php
        if (Helper::checkRoute('delete')) :
            echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        endif;
        ?>
    </div>

    <div class="row">
        <div class="col-6 col-sm-12 col-md-6">
            <div class="card rounded shadow border-0">
                <div class="card-header fw-bold">
                    <i class="bi bi-eye-fill"></i> Master Data
                </div>
                <div class="card-body">
                    <?php try {
                        echo DetailView::widget([
                            'model' => $model,
                            'options' => [
                                'class' => 'table table-bordered table-detail-view'
                            ],
                            'attributes' => [
                                'nomor',
                                [
                                    'attribute' => 'mata_uang_id',
                                    'value' => $model->mataUang->nama
                                ],
                                'tanggal:date',
                                [
                                    'attribute' => 'customer_id',
                                    'value' => $model->customer->nama
                                ],
                                'tanggal_batas_valid:date',
                                'attendant_1',
                                'attendant_phone_1',
                                'attendant_email_1:email',
                                'attendant_2',
                                'attendant_phone_2',
                                'attendant_email_2:email',
                                'vat_percentage',
                                [
                                    'attribute' => 'rekening_id',
                                    'value' => $model->rekening->atas_nama,
                                    'format' => 'nText'
                                ],
                                [
                                    'attribute' => 'signature_orang_kantor_id',
                                    'value' => $model->signatureOrangKantor->nama,
                                ]
                            ],
                        ]);
                    } catch (Throwable $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-12 col-md-6">
            <div class="card rounded shadow border-0">
                <div class="card-header fw-bold">
                    <i class="bi bi-eye-fill"></i> Summary
                </div>
                <div class="card-body">
                    <table class="table table-bordered">

                        <tbody>
                        <tr class="table-success">
                            <th>No</th>
                            <th>Fee (Sebelum Discount)</th>
                            <th></th>
                            <th class="text-end">Nominal</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Material (Barang) Fee</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationBarangsBeforeDiscountSubtotal, 2) ?></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Delivery Fee</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->delivery_fee, 2) ?></td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Service Fee</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationServicesBeforeDiscountDasarPengenaanPajak, 2) ?></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Materai Fee</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->materai_fee, 2) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-end fw-bold">Total</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->getQuotationFeeTotal(), 2) ?></td>
                        </tr>
                        </tbody>

                        <!-- Tax -->
                        <tbody>
                        <tr class="table-warning">
                            <th>No</th>
                            <th>Tax</th>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <th class="text-end">Nominal</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Barang</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationBarangsTotalVatNominal, 2) ?></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Service</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end"><?= Yii::$app->formatter->asDecimal($model->quotationServicesTotalVatNominal, 2) ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-end fw-bold">Total</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->quotationVatTotal, 2) ?></td>
                        </tr>


                        </tbody>

                        <!-- Discount -->
                        <tbody>
                        <tr class="table-info">
                            <th>No</th>
                            <th>Discount</th>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <th class="text-end">Nominal</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Barang</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end">
                                <?= Yii::$app->formatter->asDecimal($model->quotationBarangsDiscount, 2) ?>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Service</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end">
                                <?= Yii::$app->formatter->asDecimal($model->quotationServicesDiscount, 2) ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-end fw-bold">Total</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end fw-bold">
                                <?= Yii::$app->formatter->asDecimal($model->quotationDiscountTotal, 2) ?>
                            </td>
                        </tr>
                        </tbody>
                        <tbody>
                        <tr class="table-primary">
                            <td></td>
                            <td class="text-end fw-bold">Grand Total</td>
                            <td><?= $model->mataUang->singkatan ?></td>
                            <td class="text-end fw-bold"><?= Yii::$app->formatter->asDecimal($model->quotationGrandTotal, 2) ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('_view_quotation_barang', ['model' => $model]) ?>
    <?= $this->render('_view_quotation_service', ['model' => $model]) ?>
    <?= $this->render('_view_quotation_term_and_condition', ['model' => $model]) ?>

</div>