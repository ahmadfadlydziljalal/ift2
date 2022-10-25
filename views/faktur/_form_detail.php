<?php

use app\models\Faktur;
use app\models\FakturDetail;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\base\InvalidConfigException;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\widgets\MaskedInput;

/** @var $model Faktur*/
/** @var $modelsDetail array*/
/** @var $form ActiveForm*/

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
        'formFields' => ['id', 'faktur_id', 'barang_id', 'quantity', 'satuan_id', 'vendor_id' ,'harga_barang',],
    ]);
    ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="d-none">#</th>
                <th>Barang</th>
                <th>Vendor</th>
                <th>Satuan</th>
                <th style="width: 148px" >Quantity</th>
                <th>Harga</th>
                <th style="width: 2px">Aksi</th>
            </tr>
            </thead>

            <tbody class="container-items">

            <?php /** @var FakturDetail $modelDetail */
            foreach ($modelsDetail as $i => $modelDetail): ?>
                <tr class="item">

                    <td style="width: 2px;" class="align-middle d-none">
                        <?php if (!$modelDetail->isNewRecord) {
                            echo Html::activeHiddenInput($modelDetail, "[$i]id");
                        } ?>
                        <i class="bi bi-arrow-right-short"></i>
                    </td>

                    <td class="column-barang">
                        <?= $this->render('_form_column_barang', [
                            'modelDetail' => $modelDetail,
                            'form' => $form,
                            'i' => $i
                        ]) ?>
                    </td>

                    <td class="column-vendor">
                        <?= $this->render('_form_column_vendor', [
                            'modelDetail' => $modelDetail,
                            'form' => $form,
                            'i' => $i,
                            'model' => $model
                        ])
                        ?>
                    </td>

                    <td >
                        <?= $this->render('_form_column_satuan', [
                            'modelDetail' => $modelDetail,
                            'form' => $form,
                            'i' => $i,
                            'model' => $model
                        ])
                        ?>
                    </td>

                    <td>
                        <?php try {
                            echo $form->field($modelDetail, "[$i]quantity", ['template' =>
                                '{input}{error}{hint}', 'options' => ['class' => null]])
                                ->textInput([
                                    'class' => 'form-control quantity',
                                    'type' => 'number'
                                ]);
                        } catch (InvalidConfigException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </td>

                    <td>
                        <?php try {
                            echo $form->field($modelDetail, "[$i]harga_barang", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
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
                                        'class' => 'form-control harga-barang'
                                    ]
                                ]);
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
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
                    <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-primary',]); ?>
                </td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>

    <?php DynamicFormWidget::end(); ?>
</div>