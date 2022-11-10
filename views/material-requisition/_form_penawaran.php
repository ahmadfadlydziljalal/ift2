<?php


/* @var $this View */

/* @var $modelMaterialRequisition MaterialRequisition */

/* @var $modelsDetail MaterialRequisitionDetailPenawaran[]|string */

use app\models\Card;
use app\models\MataUang;
use app\models\MaterialRequisition;
use app\models\MaterialRequisitionDetailPenawaran;
use app\models\Status;
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\MaskedInput;

?>

<div class="mt-3">
    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form',
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
        'errorSummaryCssClass' => 'alert alert-danger'
    ]) ?>

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
        'formFields' => ['id', 'material_requisition_detail_id', 'vendor_id', 'harga_penawaran', 'status_id'],
    ]);
    ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="8">Material requisition detail</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Vendor</th>
                <th scope="col">Mata Uang</th>
                <th scope="col" class="text-end">Quantity</th>
                <th scope="col" class="text-end">Harga Penawaran @item</th>
                <th scope="col">Status</th>
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
                        <?= $form->field($modelDetail, "[$i]vendor_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                            ->widget(Select2::class, [
                                'data' => Card::find()->map(Card::GET_ONLY_VENDOR),
                                'options' => [
                                    'placeholder' => '= Pilih vendor ='
                                ]
                            ])
                        ?>
                    </td>

                    <td>

                        <?php
                        $data = [];

                        if (Yii::$app->request->isPost || !$modelDetail->isNewRecord) {
                            if ($modelDetail->mata_uang_id) {
                                $mataUang = MataUang::findOne([
                                    $modelDetail->mata_uang_id
                                ]);
                                $data = [
                                    $mataUang->id => $mataUang->singkatan
                                ];
                            }
                        }
                        ?>

                        <?= $form->field($modelDetail, "[$i]mata_uang_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                            ->widget(DepDrop::class, [
                                'data' => $data,
                                'options' => [
                                    'placeholder' => ' - ',
                                ],
                                'pluginOptions' => [
                                    'depends' => ['materialrequisitiondetailpenawaran-' . $i . '-vendor_id'],
                                    'url' => Url::to(['card/depdrop-find-mata-uang-by-card-id'])
                                ]
                            ]);
                        ?>
                    </td>

                    <td>
                        <?= $form->field($modelDetail, "[$i]quantity", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                            ->textInput([
                                'class' => 'form-control quantity text-end',
                                'type' => 'number'
                            ])
                        ?>
                    </td>

                    <td>
                        <?= $form->field($modelDetail, "[$i]harga_penawaran", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
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
                                    'class' => 'form-control harga-penawaran'
                                ]
                            ]);
                        ?>
                    </td>

                    <td>
                        <?= $form->field($modelDetail, "[$i]status_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                            ->dropDownList(Status::find()->map(Status::MATERIAL_REQUISITION_DETAIL_PENAWARAN_STATUS))
                        ?>
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

    <div class="d-flex justify-content-between">
        <?= Html::a(' Tutup', ['material-requisition/view', 'id' => $modelMaterialRequisition->id], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>