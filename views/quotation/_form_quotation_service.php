<?php


/* @var $this View */
/* @var $models QuotationService[] */

/* @var $quotation Quotation */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use app\models\QuotationService;
use app\models\Satuan;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\web\View;

?>


<div class="quotation-form">
    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form'
    ]) ?>

    <div class="card bg-transparent mb-3">

        <div class="card-header d-flex justify-content-between fw-bold">Master Quotation</div>

        <div class="card-body">

            <div class="row row-cols-1">
                <div class="col">
                    <?= $form->field($quotation, 'catatan_quotation_service')
                        ->label("Note")
                        ->textarea([
                            'rows' => 4
                        ])
                    ?>
                </div>
            </div>

        </div>
    </div>


    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.item',
        'limit' => 100,
        'min' => 1,
        'insertButton' => '.add-item',
        'deleteButton' => '.remove-item',
        'model' => $models[0],
        'formId' => 'dynamic-form',
        'formFields' => ['id', 'job_description', 'quantity', 'satuan_id', 'rate', 'discount'],
    ]); ?>

    <div class="d-flex flex-column gap-3 container-items">

        <?php foreach ($models as $i => $model) : ?>

            <div class="card bg-transparent item">

                <div class="card-header d-flex justify-content-between">
                    <?php if (!$model->isNewRecord) {
                        echo Html::activeHiddenInput($model, "[$i]id");
                    } ?>

                    <?= Html::tag('span', 'Quotation Service', ['class' => 'fw-bold']) ?>
                    <?= Html::button('<i class="bi bi-x-lg"> </i>', [
                        'class' => 'remove-item btn btn-danger btn-sm rounded-circle'
                    ]) ?>
                </div>

                <div class="card-body">

                    <div class="row row-cols-2 row-cols-lg-4 row-cols-xl-5">

                        <!-- Job description -->
                        <div class="col">
                            <?= $form->field($model, "[$i]job_description") ?>
                        </div>

                        <!-- quantity-->
                        <div class="col">
                            <?= $form->field($model, "[$i]quantity");
                            ?>
                        </div>

                        <div class="col">
                            <?= $form->field($model, "[$i]satuan_id")->dropDownList(Satuan::find()->mapForKategoriJasa()); ?>
                        </div>

                        <!-- Rate Per Hour -->
                        <div class="col">
                            <?= $form->field($model, "[$i]rate")->widget(NumberControl::class, [
                                'maskedInputOptions' => [
                                    'allowMinus' => false
                                ],
                            ]) ?>
                        </div>

                        <!-- Discount -->
                        <div class="col">
                            <?= $form->field($model, "[$i]discount")->textInput([
                                'class' => 'form-control quantity',
                                'type' => 'number'
                            ]) ?>
                        </div>

                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="d-flex justify-content-center my-2">
        <?php echo Html::button(TextLinkEnum::TAMBAH->value, ['class' => 'add-item btn btn-primary']); ?>
    </div>

    <?php DynamicFormWidget::end() ?>

    <div class="d-flex justify-content-between">
        <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>