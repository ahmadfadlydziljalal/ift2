<?php


/* @var $this View */

/* @var $modelsDetail array */

/* @var $form ActiveForm */

use app\models\Barang;
use app\models\Satuan;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\base\InvalidConfigException;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;
use yii\widgets\MaskedInput;

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
        'formFields' => ['id', 'purchase_order_id', 'barang_id', 'vendor_id', 'quantity', 'satuan_id', 'price',],
    ]);
    ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="6">Purchase order detail</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Barang</th>
                <th scope="col" style="width: 140px">Quantity</th>
                <th scope="col">Satuan</th>
                <th scope="col">Price</th>
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
                        <?php try {
                            echo $form->field($modelDetail, "[$i]barang_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                                ->widget(Select2::class, [
                                    'data' => Barang::find()->map(),
                                    'options' => [
                                        'prompt' => '= Pilih salah satu ='
                                    ]
                                ]);
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
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
                        <?= $form->field($modelDetail, "[$i]satuan_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                            ->dropDownList(Satuan::find()->map(), [
                                'prompt' => '= Pilih salah satu ='
                            ]); ?>
                    </td>

                    <td>
                        <?php try {
                            echo $form->field($modelDetail, "[$i]price", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
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
                                        'class' => 'form-control price'
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
                    <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-success',]); ?>
                </td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>

    <?php DynamicFormWidget::end(); ?>
</div>