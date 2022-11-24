<?php


/* @var $this View */
/* @var $models QuotationFormJob */

/* @var $quotation Quotation */

use app\enums\TextLinkEnum;
use app\models\Card;
use app\models\CardOwnEquipment;
use app\models\Quotation;
use app\models\QuotationFormJob;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\web\View;

?>


<div class="quotation-form">
    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form'
    ]) ?>

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
        'formFields' => ['id', 'tanggal', 'person_in_charge', 'issue', 'card_own_equipment_id', 'hour_meter', 'mekanik_id'],
    ]); ?>

    <div class="d-flex flex-column gap-3 container-items">

        <?php foreach ($models as $i => $model) : ?>

            <div class="card rounded border-0 shadow item">

                <div class="card-header d-flex justify-content-between">
                    <?php if (!$model->isNewRecord) {
                        echo Html::activeHiddenInput($model, "[$i]id");
                    } ?>

                    <?= Html::tag('span', 'Form Job', ['class' => 'fw-bold']) ?>
                    <?= Html::button('<i class="bi bi-x-lg"> </i>', [
                        'class' => 'remove-item btn btn-danger btn-sm rounded-circle'
                    ]) ?>
                </div>

                <div class="card-body">

                    <div class="row row-cols-2 row-cols-lg-4">

                        <!-- Tanggal -->
                        <div class="col">
                            <?= $form->field($model, "[$i]tanggal")->widget(DatePicker::class); ?>
                        </div>

                        <div class="col">
                            <?= $form->field($model, "[$i]person_in_charge"); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <?= $form->field($model, "[$i]card_own_equipment_id")
                                ->widget(Select2::class, [
                                    'data' => CardOwnEquipment::find()->byCardId($quotation->customer_id),
                                    'options' => [
                                        'placeholder' => '= Pilih unit (jika ada) ='
                                    ]
                                ]);
                            ?>

                            <?= $form->field($model, "[$i]hour_meter"); ?>

                            <?= $form->field($model, "[$i]mekanik_id")->widget(Select2::class, [
                                'data' => Card::find()->map(Card::GET_ONLY_MEKANIK),
                                'options' => [
                                    'placeholder' => '= Pilih unit (jika ada) ='
                                ]
                            ]); ?>
                        </div>

                        <div class="col-12 col-lg-9">
                            <?= $form->field($model, "[$i]issue")->textarea([
                                'rows' => 4
                            ]); ?>
                            <?= $form->field($model, "[$i]remarks")->textarea([
                                'rows' => 4
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
    <div class="d-flex justify-content-center my-2">
        <?php echo Html::button(TextLinkEnum::TAMBAH->value, ['class' => 'add-item btn btn-primary']); ?>
    </div>
    <?php DynamicFormWidget::end(); ?>

    <div class="d-flex justify-content-between">
        <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>