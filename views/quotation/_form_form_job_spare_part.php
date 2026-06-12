<?php

use app\models\Barang;
use app\models\BarangSatuan;
use app\models\QuotationFormJob;
use app\models\QuotationFormJobJobs;
use app\models\QuotationFormJobSparePart;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $quotationFormJobModel QuotationFormJob */
/* @var $models QuotationFormJobSparePart[] */

/* @var $this View */


?>

<div class="quotation-form">
    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form'
    ]) ?>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody'      => '.container-items',
        'widgetItem'      => '.item',
        'limit'           => 100,
        'min'             => 1,
        'insertButton'    => '.add-item',
        'deleteButton'    => '.remove-item',
        'model'           => $models[0],
        'formId'          => 'dynamic-form',
        'formFields'      => ['id', 'job_description', 'quantity', 'satuan_id', 'rate', 'discount'],
    ]); ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">
                    Nama Job
                </th>
                <th scope="col" style="width: 128px">Quantity</th>
                <th scope="col" style="width: 30%">Satuan</th>
                <th scope="col" style="width: 2px"></th>
            </tr>
            </thead>

            <tbody class="container-items">
            <?php /** @var QuotationFormJobJobs $modelDetail */ ?>
            <?php foreach ($models as $i => $modelDetail): ?>
                <tr class="item">
                    <td style="width: 2px;" class="align-middle">
                        <?php if (!$modelDetail->isNewRecord) {
                            echo Html::activeHiddenInput($modelDetail, "[$i]id");
                        } ?>
                        <i class="bi bi-arrow-right-short"></i>
                    </td>

                    <td>
                        <?= $form->field($modelDetail, "[$i]barang_id", [
                            'template' => '{input}{error}{hint}',
                            'options'  => ['class' => null]
                        ])->widget(Select2::class, [
                            'data'    => Barang::find()->map(),
                            'options' => [
                                'prompt' => '= Pilih Salah Satu =',
                                'class'  => 'form-control barang'
                            ],
                        ]); ?>
                    </td>
                    <td>
                        <?= $form->field($modelDetail, "[$i]quantity", [
                            'template' => '{input}{error}{hint}',
                            'options'  => ['class' => null]
                        ]) ?>
                    </td>

                    <td>
                        <?php
                        /*$data2 = [];
                        if (Yii::$app->request->isPost) {
                            if ($modelDetail->satuan_id) {
                                $data2 = BarangSatuan::find()->mapSatuan($modelDetail->barang_id);
                            }
                        }*/

                        $data2 = (!empty($modelDetail->satuan_id))
                            ? BarangSatuan::find()->mapSatuan($modelDetail->barang_id) : [];
                        ?>
                        <?= $form->field($modelDetail, "[$i]satuan_id", [
                            'template' => '{input}{error}{hint}',
                            'options'  => ['class' => null]
                        ])
                            ->widget(DepDrop::class, [
                                'data'          => $data2,
                                'pluginOptions' => [
                                    'depends' => [
                                        'quotationformjobsparepart-' . $i . '-barang_id'
                                    ],

                                    'url' => Url::to(['/barang/depdrop-find-satuan-by-barang'])
                                ],
                                'options'       => [
                                    'class'       => 'form-control satuan',
                                    'placeholder' => 'Select...',
                                ]
                            ]);
                        //->dropDownList(Satuan::find()->map(KategoriSatuanEnum::BARANG->value));              ?>
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

                <td class="text-end" colspan="4">
                    <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-success',]); ?>
                </td>
                <td></td>

            </tr>

        </table>
    </div>

    <?php DynamicFormWidget::end() ?>
    <div class="d-flex justify-content-between">
        <?= Html::a(' Tutup', ['quotation/view', 'id' => $quotationFormJobModel->quotation_id, '#' => 'quotation-tab-tab4'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>

</div>