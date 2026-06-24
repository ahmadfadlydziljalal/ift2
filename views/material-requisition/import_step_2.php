<?php

/* @var $this yii\web\View */
/* @var $model app\models\form\ImportMaterialRequestForm */
/* @var $modelsDetail app\models\form\ImportMaterialRequestExcelFormRecord[] */

/* @see \app\controllers\MaterialRequisitionController::actionImport() */

use app\enums\KategoriSatuanEnum;
use app\models\Barang;
use app\models\Card;
use app\models\Satuan;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\MaskedInput;

$this->title = 'Import Material Request';
$this->params['breadcrumbs'][] = ['label' => 'Material Requisition', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Import', 'url' => ['import']];
$this->params['breadcrumbs'][] = $this->title;

$fieldConfig = [
    'template' => '<div class="mb-3 row"><div class="col-sm-3">{label}</div><div class="col-sm-9">{input}{error}</div> </div>'
];
?>

<div class="material-requisition-import-step-two">

    <h1 class="mb-3"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id'                     => 'dynamic-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => false,
    ]) ?>

    <div class="row">
        <div class="col-12 col-lg-7">
            <?= $form->field($model, 'toOrangKantor', $fieldConfig)->widget(Select2::class, [
                'data'          => Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR),
                'pluginOptions' => [
                    'placeholder' => '= Pilih orang kantor =',
                    'autofocus'   => 'autofocus'
                ]
            ]) ?>
            <?= $form->field($model, 'tanggal', $fieldConfig)->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
            <?= $form->field($model, 'remarks', $fieldConfig)->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'approvedBy', $fieldConfig)->widget(Select2::class, [
                'data'    => Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR),
                'options' => [
                    'placeholder' => '= Pilih orang kantor ='
                ]
            ]) ?>
            <?= $form->field($model, 'acknowledgeBy', $fieldConfig)->widget(Select2::class, [
                'data'    => Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR),
                'options' => [
                    'placeholder' => '= Pilih orang kantor ='
                ]
            ]) ?>
        </div>
    </div>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody'      => '.container-items',
        'widgetItem'      => '.item',
        'limit'           => 100,
        'min'             => 1,
        'insertButton'    => '.add-item',
        'deleteButton'    => '.remove-item',
        'model'           => $modelsDetail[0],
        'formId'          => 'dynamic-form',
        'formFields'      => ['part_number'],
    ]);
    ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr class="text-nowrap">
                <th scope="col" class="text-end">#</th>
                <th scope="col">Part Number</th>
                <th scope="col">Satuan</th>
                <th scope="col">Description</th>
                <th scope="col">Kode Vendor</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price Per Item</th>
                <th scope="col">Total Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Remark</th>

                <!--<th scope="col" style="width: 2px">Aksi</th>-->
            </tr>
            </thead>

            <tbody class="container-items">

            <?php /** @var app\models\form\ImportMaterialRequestExcelFormRecord[] $modelsDetail */ ?>
            <?php $template = ['template' => '{input}{error}{hint}', 'options' => ['class' => null]] ?>
            <?php foreach ($modelsDetail as $i => $modelDetail): ?>
                <tr class="item">

                    <td style="width: 2px;" class="text-end"><?= $modelDetail->nomor ?></td>
                    <td><?= $form->field($modelDetail, "[$i]part_number", $template)->widget(Select2::class, [
                            'options'       => [
                                'placeholder' => '...'
                            ],
                            'initValueText' => !is_null($modelDetail->part_number) ? Barang::findOne($modelDetail->part_number)?->part_number : '',
                            'pluginOptions' => [
                                'allowClear'         => true,
                                'minimumInputLength' => 3,
                                'language'           => [
                                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                ],
                                'ajax'               => [
                                    'url'      => Url::to(['find-barang']), /* @see \app\controllers\MaterialRequisitionController::actionFindBarang() */
                                    'dataType' => 'json',
                                    'data'     => new JsExpression('function(params) { return { q:params.term, id: params.id } }'),
                                    'delay'    => 1000
                                ],
                                'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                                'templateResult'     => new JsExpression('function(result) { return result.text; }'),
                                'templateSelection'  => new JsExpression('function (result) { return result.text; }'),
                            ],
                        ]); ?></td>
                    <td><?= $form->field($modelDetail, "[$i]satuan_id", $template)->dropDownList(Satuan::find()->map(KategoriSatuanEnum::BARANG->value), [
                            'prompt' => '...',
                        ]) ?>
                    </td>
                    <td><?= $form->field($modelDetail, "[$i]description", $template) ?></td>
                    <td><?= $form->field($modelDetail, "[$i]kode_vendor", $template)->dropDownList(Card::find()->map(Card::GET_ONLY_VENDOR, 'id', 'kode')) ?></td>
                    <td><?= $form->field($modelDetail, "[$i]quantity", $template)->textInput([
                            'maxlength' => true,
                            'type'      => 'number',
                            'class'     => 'text-end'
                        ]) ?></td>
                    <td><?= $form->field($modelDetail, "[$i]harga_per_item", $template)->widget(MaskedInput::class, [
                            'clientOptions' => [
                                'alias'              => 'numeric',
                                'groupSeparator'     => '.',  // Pemisah ribuan
                                'radixPoint'         => ',',  // Pemisah desimal
                                'autoGroup'          => true, // Otomatis mengelompokkan ribuan
                                'digits'             => 0,    // Set ke 0 jika tidak pakai sen (desimal)
                                'digitsOptional'     => false,
                                //'prefix'             => 'Rp',            // Menambahkan simbol Rupiah di depan
                                'unmaskAsNumber'     => true, // Sangat penting! Mengirim angka murni ke controller
                                'removeMaskOnSubmit' => true, // Menghapus format topeng saat form di-submit
                            ],
                        ]) ?></td>
                    <td><?= $form->field($modelDetail, "[$i]total_harga", $template)->widget(MaskedInput::class, [
                            'clientOptions' => [
                                'alias'              => 'numeric',
                                'groupSeparator'     => '.',  // Pemisah ribuan
                                'radixPoint'         => ',',  // Pemisah desimal
                                'autoGroup'          => true, // Otomatis mengelompokkan ribuan
                                'digits'             => 0,    // Set ke 0 jika tidak pakai sen (desimal)
                                'digitsOptional'     => false,
                                //'prefix'             => 'Rp',            // Menambahkan simbol Rupiah di depan
                                'unmaskAsNumber'     => true, // Sangat penting! Mengirim angka murni ke controller
                                'removeMaskOnSubmit' => true, // Menghapus format topeng saat form di-submit
                            ],
                        ]) ?></td>
                    <td><?= $form->field($modelDetail, "[$i]stock", $template)->textInput([
                            'maxlength' => true,
                            'type'      => 'number',
                            'class'     => 'text-end'
                        ]) ?></td>
                    <td><?= $form->field($modelDetail, "[$i]remark", $template) ?></td>


                    <!--<td>
                        <button type="button" class="remove-item btn btn-link text-danger">
                            <i class="bi bi-trash"> </i>
                        </button>
                    </td>-->
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>

    <?php DynamicFormWidget::end(); ?>

    <div class="d-flex justify-content-between">
        <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton(' Integrasi!', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
