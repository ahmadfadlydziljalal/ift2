<?php

use app\enums\CaraPenulisanLokasiEnum;
use app\models\Barang;
use app\models\form\BarangStart;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this View */
/* @var $model BarangStart */
/* @see \app\controllers\BarangController::actionStart() */

$this->title = $model->isRestart ? 'Restart Barang' : 'Start Barang';
$this->params['breadcrumbs'][] = ['label' => 'Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$barang = $model->barangId ? Barang::findOne($model->barangId) : null;
$urlSatuan = Url::to(['barang/default-satuan']);

$this->registerJs(<<<JS
$('#barangstart-barangid').on('change', function () {
    var id = $(this).val(), info = $('#info-default-satuan');
    info.text('');
    if (!id) return;
    $.getJSON('$urlSatuan', {id: id}, function (r) { info.text(r.satuan ? 'Satuan: ' + r.satuan : ''); });
});
JS);

$plainField = static function ($model, $attribute) use (&$form) {
    $field = $form->field($model, $attribute, ['template' => '{input}{error}', 'options' => ['class' => null]]);
    Html::removeCssClass($field->options, 'row');
    return $field;
};

$dropdown = static fn(CaraPenulisanLokasiEnum $type) => [
        'data'    => CaraPenulisanLokasiEnum::getDropdown($type),
        'options' => ['prompt' => '= Pilih ='],
];
?>

<div class="barang-start">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']) ?>

    <div class="row">
        <div class="col-12 col-lg-6">
            <?= $form->field($model, 'barangId')->widget(Select2::class, [
                    'initValueText' => $barang?->nama,
                    'disabled'      => $model->isRestart,
                    'options'       => ['placeholder' => 'Cari barang tipe stock'],
                    'pluginOptions' => [
                            'allowClear'         => true,
                            'minimumInputLength' => 3,
                            'ajax'               => [
                                    'url'      => Url::to(['barang/find-type-stock']), /** @see \app\controllers\BarangController::actionFindTypeStock */
                                    'dataType' => 'json',
                                    'data'     => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                            'templateResult'     => new JsExpression('function(d) { return d.text; }'),
                            'templateSelection'  => new JsExpression('function(d) { return d.text; }'),
                    ],
            ])->hint('<span id="info-default-satuan" class="fw-bold">' .
                    ($barang?->defaultSatuan ? 'Satuan: ' . Html::encode($barang->defaultSatuan->nama) : '') . '</span>') ?>
        </div>
        <div class="col-12 col-lg-6">
            <?= $form->field($model, 'initializeStockQuantity')->textInput(['type' => 'number', 'step' => 'any']) ?>
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
            'model'           => $model->lokasi[0],
            'formId'          => 'dynamic-form',
            'formFields'      => ['quantity', 'cardId', 'block', 'rak', 'tier', 'row', 'catatan'],
    ]); ?>

    <div class="d-flex justify-content-end mb-2">
        <?= Html::button('<i class="bi bi-plus-circle"></i> Tambah Baris', ['class' => 'add-item btn btn-outline-success']) ?>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Quantity</th>
                <th>Gudang</th>
                <th>Block</th>
                <th>Rak</th>
                <th>Tier</th>
                <th>Row</th>
                <th>Catatan</th>
                <th class="text-center">Action</th>
            </tr>
            </thead>
            <tbody class="container-items">
            <?php foreach ($model->lokasi as $i => $lokasi) : ?>
                <tr class="item">
                    <td><?= $plainField($lokasi, "[$i]quantity")->textInput(['type' => 'number', 'step' => 'any']) ?></td>
                    <td><?= $plainField($lokasi, "[$i]cardId")->widget(Select2::class, $dropdown(CaraPenulisanLokasiEnum::GUDANG)) ?></td>
                    <td><?= $plainField($lokasi, "[$i]block")->widget(Select2::class, $dropdown(CaraPenulisanLokasiEnum::BLOCK)) ?></td>
                    <td><?= $plainField($lokasi, "[$i]rak")->widget(Select2::class, $dropdown(CaraPenulisanLokasiEnum::RAK)) ?></td>
                    <td><?= $plainField($lokasi, "[$i]tier")->widget(Select2::class, $dropdown(CaraPenulisanLokasiEnum::TIER)) ?></td>
                    <td><?= $plainField($lokasi, "[$i]row")->widget(Select2::class, $dropdown(CaraPenulisanLokasiEnum::ROW)) ?></td>
                    <td><?= $plainField($lokasi, "[$i]catatan")->textInput() ?></td>
                    <td class="text-center">
                        <button type="button" class="remove-item btn btn-link text-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php DynamicFormWidget::end(); ?>

    <div class="d-flex justify-content-between mt-3">
        <?= Html::a('Tutup', $barang ? ['view', 'id' => $barang->id] : ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton('<i class="bi bi-save-fill"></i> Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
