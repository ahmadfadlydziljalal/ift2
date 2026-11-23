<?php

use app\models\BarangSatuan;
use app\models\Card;
use app\models\Satuan;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $modelsDetail BarangSatuan[] */
/** @var $form ActiveForm */

$plainField = static function ($model, $attribute, $config) use ($form) {
    $field = $form->field($model, $attribute, $config);
    Html::removeCssClass($field->options, 'row'); // kartik horizontal form adds `row`
    return $field;
};

?>

<div class="form-detail">

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
            'formFields'      => ['id', 'vendor_id', 'barang_id', 'satuan_id', 'harga_beli', 'harga_jual'],
    ]); ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="5">Barang satuan</th>
                <th><?= Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-outline-success',]); ?></th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Satuan</th>
                <th scope="col">Vendor</th>
                <th scope="col">Harga Beli</th>
                <th scope="col">Harga Jual</th>
                <th scope="col" style="width:116px" class="text-center">Aksi</th>
            </tr>
            </thead>

            <tbody class="container-items">

            <?php foreach ($modelsDetail as $i => $modelDetail) : ?>
                <tr class="item">

                    <td style="width: 2px;" class="align-middle">
                        <?php if (!$modelDetail->isNewRecord) {
                            echo Html::activeHiddenInput($modelDetail, "[$i]id");
                        } ?>
                        <i class="bi bi-arrow-right-short"></i>
                    </td>

                    <td>
                        <?= $plainField($modelDetail, "[$i]satuan_id", [
                                'template' => '{input}{error}{hint}',
                                'options'  => ['class' => null]])
                                ->dropDownList(Satuan::find()->map(), [
                                        'prompt' => '= Pilih Salah Satu ='
                                ]);
                        ?>
                    </td>
                    <td>
                        <?= $plainField($modelDetail, "[$i]vendor_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])->widget(Select2::class, [
                                'data'    => Card::find()->map(),
                                'options' => [
                                        'prompt' => '= Pilih Salah Satu ='
                                ]
                        ]);
                        ?>
                    </td>
                    <td><?= $plainField($modelDetail, "[$i]harga_beli", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])->widget(NumberControl::class); ?></td>
                    <td><?= $plainField($modelDetail, "[$i]harga_jual", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])->widget(NumberControl::class); ?></td>
                    <td class="text-center">
                        <button type="button" class="remove-item btn btn-link text-danger">
                            <i class="bi bi-trash"> </i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>

        </table>
    </div>

    <?php DynamicFormWidget::end(); ?>

</div>