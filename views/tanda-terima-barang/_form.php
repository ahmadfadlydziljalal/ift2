<?php

use app\models\Card;
use app\models\TandaTerimaBarangDetail;
use kartik\datecontrol\DateControl;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TandaTerimaBarang */
/* @var $modelsDetail app\models\MaterialRequisitionDetailPenawaran */
/* @var $modelsDetailDetail app\models\TandaTerimaBarangDetail */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="tanda-terima-barang-form">

    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form',
        'layout' => ActiveForm::LAYOUT_HORIZONTAL,
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4 col-form-label',
                'offset' => 'offset-sm-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],

        /*'layout' => ActiveForm::LAYOUT_FLOATING,
        'fieldConfig' => [
            'options' => [
                'class' => 'form-floating'
            ]
        ]*/
    ]); ?>

    <div class="d-flex flex-column mt-0" style="gap: 1rem">
        <div class="form-master">
            <div class="row">
                <div class="col-12 col-lg-7">
                    <?php echo $form->field($model, 'tanggal')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]); ?>
                    <?php echo $form->field($model, 'catatan')->textarea(['rows' => 6]); ?>
                    <?php echo $form->field($model, 'received_by')->textInput(['maxlength' => true]); ?>
                    <?php echo $form->field($model, 'messenger')->textInput(['maxlength' => true]); ?>
                    <?php echo $form->field($model, 'acknowledge_by_id')->dropDownList(Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR)); ?>
                </div>
            </div>
        </div>

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
                'formFields' => ['id', 'tanda_terima_barang_id', 'material_requisition_detail_penawaran_id', 'quantity_terima',],
            ]);
            ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Barang</th>
                        <th scope="col">Satuan</th>
                        <th scope="col">Quantity Pesan</th>
                        <th scope="col">Quantity terima</th>
                    </tr>
                    </thead>

                    <tbody class="container-items">

                    <?php /** @var TandaTerimaBarangDetail $modelDetail */
                    foreach ($modelsDetail as $i => $modelDetail): ?>
                        <tr class="item">

                            <td style="width: 2px;" class="align-middle">
                                <?php if (!$modelDetail->isNewRecord) {
                                    echo Html::activeHiddenInput($modelDetail, "[$i]id");
                                } ?>
                                <?php echo Html::activeHiddenInput($modelDetail, "[$i]material_requisition_detail_penawaran_id"); ?>
                                <i class="bi bi-arrow-right-short"></i>
                            </td>

                            <td style="vertical-align: middle">
                                <?= $modelDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->barang->nama ?>
                            </td>

                            <td style="vertical-align: middle">
                                <?= $modelDetail->materialRequisitionDetailPenawaran->materialRequisitionDetail->satuan->nama ?>
                            </td>

                            <td style="vertical-align: middle">
                                <?= $modelDetail->materialRequisitionDetailPenawaran->quantity_pesan ?>
                            </td>

                            <td>
                                <?= $form->field($modelDetail, "[$i]quantity_terima", [
                                        'template' => '{input}{error}{hint}',
                                        'options' => ['class' => null]]
                                ); ?>
                            </td>


                        </tr>
                    <?php endforeach; ?>

                    </tbody>

                </table>
            </div>

            <?php DynamicFormWidget::end(); ?>

            <div class="d-flex justify-content-between mt-3">
                <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton(' Simpan', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>