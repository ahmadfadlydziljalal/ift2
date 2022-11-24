<?php


/* @var $this View */

/* @var $model Quotation|string|ActiveRecord */

use app\models\Quotation;
use yii\db\ActiveRecord;
use yii\web\View;

?>

<div class="card rounded shadow border-0" id="summary">
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