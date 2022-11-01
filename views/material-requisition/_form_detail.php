<?php


/* @var $this View */
/* @var $form ActiveForm */

/* @var $modelsDetail MaterialRequisitionDetail[] */

use app\models\Barang;
use app\models\MaterialRequisitionDetail;
use app\models\Satuan;
use app\models\TipePembelian;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>


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
        'formFields' => ['id', 'material_requisition_id', 'barang_id', 'description', 'quantity', 'satuan_id', 'waktu_permintaan_terakhir', 'harga_terakhir', 'stock_terakhir',],
    ]);
    ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="10">Material requisition detail</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tipe</th>
                <th scope="col">Barang</th>
                <th scope="col">Description</th>
                <th scope="col">Quantity</th>
                <th scope="col">Satuan</th>
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

                    <td><?= $form->field($modelDetail, "[$i]tipePembelian", ['template' =>
                            '{input}{error}{hint}', 'options' => ['class' => null]])
                            ->dropDownList(TipePembelian::find()->map(true), [
                                'prompt' => '-',
                                'class' => 'tipe-pembelian',
                                'id' => 'materialrequisitiondetail-' . $i . '-tipepembelian'
                            ])
                        ?>
                    </td>

                    <td class="column-barang">
                        <?php
                        $data = [];

                        if (Yii::$app->request->isPost || !$modelDetail->isNewRecord) {
                            if ($modelDetail->barang_id) {
                                $data = Barang::find()->map($modelDetail->tipePembelian);
                            }
                        }

                        ?>

                        <?= $form->field($modelDetail, "[$i]barang_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                            ->widget(DepDrop::class, [
                                'data' => $data,
                                'options' => [
                                    'id' => 'materialrequisitiondetail-' . $i . '-barang_id',
                                    'placeholder' => 'Select ...',
                                    'class' => 'form-control barang',
                                ],
                                'type' => DepDrop::TYPE_SELECT2,
                                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                'pluginOptions' => [
                                    'depends' => ['materialrequisitiondetail-' . $i . '-tipepembelian'],
                                    'placeholder' => 'Select...',
                                    'url' => Url::to(['barang/find-barang-with-tipe-pembelian-param'])
                                ]
                            ]);
                        ?></td>
                    <td><?= $form->field($modelDetail, "[$i]description", ['template' =>
                            '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                            'class' => 'form-control description'
                        ]); ?></td>
                    <td><?= $form->field($modelDetail, "[$i]quantity", ['template' =>
                            '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                            'class' => 'form-control quantity',
                            'type' => 'number'
                        ]) ?></td>
                    <td><?= $form->field($modelDetail, "[$i]satuan_id", ['template' =>
                            '{input}{error}{hint}', 'options' => ['class' => null]])->widget(Select2::class, [
                            'data' => Satuan::find()->map(),
                            'options' => [
                                'prompt' => ' - ',
                                'class' => 'satuan-id form-control',

                            ]
                        ]) ?>
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
                <td></td>
                <td class="text-end" colspan="6">
                    <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-success',]); ?>
                </td>

            </tr>
            </tfoot>
        </table>
    </div>

    <?php DynamicFormWidget::end(); ?>
</div>