<?php

use app\models\Card;
use app\models\Originalitas;
use app\models\Satuan;
use app\models\TipePembelian;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Barang */
/* @var $modelsDetail app\models\BarangSatuan */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="barang-form">

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

                    <?= $form->field($model, 'tipe_pembelian_id')->widget(Select2::class, [
                        'data' => TipePembelian::find()->map(true),
                        'pluginOptions' => [
                            'autofocus' => 'autofocus',
                            'placeholder' => '= Pilih salah satu ='
                        ]
                    ]) ?>

                    <?= $form->field($model, 'nama')->textInput([
                        'maxlength' => true,

                    ]) ?>

                    <?= $form->field($model, 'part_number')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'merk_part_number')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'originalitas_id', ['inline' => true])->radioList(Originalitas::find()->map()) ?>
                    <?= $form->field($model, 'keterangan')->textarea([
                        'rows' => '4'
                    ]) ?>
                </div>


            </div>
        </div>
        <!--<div class="row">
            <div class="col-12 col-lg-6">

            </div>

            <div class="col-12 col-lg-6">

            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">

            </div>
            <div class="col-12 col-lg-6">

            </div>
        </div>-->
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
            'formFields' => ['id', 'vendor_id', 'barang_id', 'satuan_id', 'harga_beli', 'harga_jual'],
        ]);
        ?>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th colspan="4">Barang satuan</th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Vendor</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Harga Beli</th>
                    <th scope="col">Harga Jual</th>
                    <th scope="col" style="width: 2px">Aksi</th>
                </tr>
                </thead>

                <tbody class="container-items">

                <?php foreach ($modelsDetail as $i => $modelDetail): ?>
                    <tr class="item">

                        <td style="width: 2px;" class="align-middle">
                            <?php if (!$modelDetail->isNewRecord) {
                                echo Html::activeHiddenInput($modelDetail, "[$i]id");
                            } ?>
                            <i class="bi bi-arrow-right-short"></i>
                        </td>

                        <td>
                            <?= $form->field($modelDetail, "[$i]vendor_id", ['template' =>
                                '{input}{error}{hint}', 'options' => ['class' => null]])
                                ->widget(Select2::class, [
                                    'data' => Card::find()->map(),
                                    'options' => [
                                        'prompt' => '= Pilih Salah Satu ='
                                    ]
                                ]);
                            ?>
                        </td>

                        <td>
                            <?= $form->field($modelDetail, "[$i]satuan_id", ['template' =>
                                '{input}{error}{hint}', 'options' => ['class' => null]])
                                ->dropDownList(Satuan::find()->map(), [
                                    'prompt' => '= Pilih Salah Satu ='
                                ]);
                            ?>
                        </td>
                        <td><?= $form->field($modelDetail, "[$i]harga_beli", ['template' =>
                                '{input}{error}{hint}', 'options' => ['class' => null]])->widget(NumberControl::class, [
                                'maskedInputOptions' => [
                                    'prefix' => Yii::$app->getFormatter()->currencyCode,
                                    'allowMinus' => false
                                ],
                            ]); ?>
                        </td>
                        <td><?= $form->field($modelDetail, "[$i]harga_jual", ['template' =>
                                '{input}{error}{hint}', 'options' => ['class' => null]])->widget(NumberControl::class, [
                                'maskedInputOptions' => [
                                    'prefix' => Yii::$app->getFormatter()->currencyCode,
                                    'allowMinus' => false
                                ],
                            ]); ?>
                        </td>

                        <td>
                            <button type="button" class="remove-item btn btn-link text-danger">
                                <i class="bi bi-trash"> </i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>

                <tfoot>
                <tr>
                    <td class="text-end" colspan="5">
                        <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-success',]); ?>
                    </td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>

        <?php DynamicFormWidget::end(); ?>
    </div>

    <div class="d-flex justify-content-between">
        <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>