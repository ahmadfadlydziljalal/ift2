<?php

use app\models\Card;
use app\models\MaterialRequisitionDetailPenawaran;
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

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 100, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsDetail[0],
                'formId' => 'dynamic-form',
                'formFields' => ['id', 'material_requisition_detail_id', 'vendor_id', 'mata_uang_id', 'quantity_pesan', 'harga_penawaran', 'status_id', 'purchase_order_id', 'tanda_terima_barang_id', 'created_at', 'updated_at', 'created_by', 'updated_by',],
            ]); ?>

            <div class="container-items">

                <?php /** @var MaterialRequisitionDetailPenawaran $modelDetail */
                foreach ($modelsDetail as $i => $modelDetail): ?>
                    <div class="card mb-4 item">

                        <?php if (!$modelDetail->isNewRecord) {
                            echo Html::activeHiddenInput($modelDetail, "[$i]id");
                        } ?>
                        <?php echo Html::activeHiddenInput($modelDetail, "[$i]material_requisition_detail_id") ?>
                        <?php echo Html::activeHiddenInput($modelDetail, "[$i]vendor_id") ?>
                        <?php echo Html::activeHiddenInput($modelDetail, "[$i]mata_uang_id") ?>
                        <?php echo Html::activeHiddenInput($modelDetail, "[$i]quantity_pesan") ?>
                        <?php echo Html::activeHiddenInput($modelDetail, "[$i]harga_penawaran") ?>
                        <?php echo Html::activeHiddenInput($modelDetail, "[$i]status_id") ?>
                        <?php echo Html::activeHiddenInput($modelDetail, "[$i]material_requisition_detail_id") ?>


                        <div class="card-body">
                            <p class="fw-bolder">
                                Pemesanan: <?= $modelDetail->materialRequisitionDetail->barang->nama ?>
                                <span class="badge bg-info rounded-circle"> <?= $modelDetail->quantity_pesan ?> </span>
                                <span class="badge bg-info rounded-circle"> <?= $modelDetail->materialRequisitionDetail->satuan->nama ?> </span>
                            </p>
                            <?php echo $this->render('_form-detail-detail', [
                                'form' => $form,
                                'i' => $i,
                                'modelsDetailDetail' => $modelsDetailDetail[$i],
                            ]) ?>

                        </div>

                    </div>

                <?php endforeach; ?>
            </div>


            <?php DynamicFormWidget::end(); ?>

            <div class="d-flex justify-content-between mt-3">
                <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton(' Simpan', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>