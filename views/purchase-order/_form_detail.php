<?php


/* @var $this View */

/* @var $modelsDetail array */

/* @var $form ActiveForm */

use app\models\MaterialRequisitionDetail;
use app\models\MaterialRequisitionDetailPenawaran;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\MaskedInput;

?>


<div class="form-detail">

    <?php
    DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.item',
        'limit' => 100,
        'min' => 1,
        'insertButton' => '.add-item',
        'deleteButton' => '.remove-item',
        'model' => $modelsDetail[0],
        'formId' => 'dynamic-form',
        'formFields' => ['id', 'material_requisition_detail_id', 'vendor_id', 'harga_penawaran', 'mata_uang_id', 'status_id'],
    ]);
    ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="8">Purchase order detail</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">M.R</th>
                <th scope="col" style="width: 140px">Barang</th>
                <th scope="col">Description</th>
                <th scope="col">Quantity</th>
                <th scope="col">Satuan</th>
                <th scope="col">Vendor</th>
                <th scope="col">Mata Uang</th>
                <th scope="col">Harga Penawaran</th>
            </tr>
            </thead>

            <tbody class="container-items">

            <?php /** @var MaterialRequisitionDetailPenawaran $modelDetail */
            foreach ($modelsDetail as $i => $modelDetail): ?>
                <tr class="item">

                    <td style="width: 2px;" class="align-middle">
                        <?php /** @var MaterialRequisitionDetail $modelDetail */ ?>
                        <?= Html::activeHiddenInput($modelDetail, "[$i]id"); ?>
                        <?= Html::activeHiddenInput($modelDetail, "[$i]material_requisition_detail_id") ?>
                        <?= Html::activeHiddenInput($modelDetail, "[$i]vendor_id") ?>
                        <?= Html::activeHiddenInput($modelDetail, "[$i]status_id") ?>
                        <?= Html::activeHiddenInput($modelDetail, "[$i]mata_uang_id") ?>


                        <i class="bi bi-arrow-right-short"></i>
                    </td>

                    <td>
                        <?= $modelDetail->materialRequisitionDetail->materialRequisition->nomor ?>
                    </td>

                    <td>
                        <?= $modelDetail->materialRequisitionDetail->barang->nama ?>
                    </td>

                    <td>
                        <?= $modelDetail->materialRequisitionDetail->description ?>
                    </td>

                    <td>
                        <?= $modelDetail->materialRequisitionDetail->quantity ?>
                    </td>

                    <td>
                        <?= $modelDetail->materialRequisitionDetail->satuan->nama ?>
                    </td>

                    <td>
                        <?= $modelDetail->vendor->nama ?>
                    </td>

                    <td>
                        <?= $modelDetail->mataUang->singkatan ?>
                    </td>

                    <td>
                        <?php try {
                            echo $form->field($modelDetail, "[$i]harga_penawaran", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                                ->widget(MaskedInput::class, [
                                    'clientOptions' => [
                                        'alias' => 'numeric',
                                        'digits' => 2,
                                        'groupSeparator' => ',',
                                        'radixPoint' => '.',
                                        'autoGroup' => true,
                                        'autoUnmask' => true,
                                        'removeMaskOnSubmit' => true
                                    ],
                                    'options' => [
                                        'class' => 'form-control harga-terakhir'
                                    ]
                                ]);
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </td>

                </tr>
            <?php endforeach; ?>

            </tbody>


        </table>
    </div>

    <?php DynamicFormWidget::end(); ?>
</div>