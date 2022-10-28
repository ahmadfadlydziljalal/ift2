<?php

use app\models\Barang;
use app\models\Satuan;
use app\models\TipePembelian;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $i int|string */
/* @var $model app\models\ClaimPettyCash */
/* @var $modelsDetail app\models\ClaimPettyCashNota */
/* @var $modelsDetailDetail app\models\ClaimPettyCashNotaDetail */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-rooms',
    'widgetItem' => '.room-item',
    'limit' => 99,
    'min' => 1,
    'insertButton' => '.add-room',
    'deleteButton' => '.remove-room',
    'model' => $modelsDetailDetail[0],
    'formId' => 'dynamic-form',
    'formFields' => ['id', 'claim_petty_cash_nota_id', 'tipe_pembelian_id', 'barang_id', 'description', 'quantity', 'satuan_id', 'harga',],
]); ?>

    <table class="table table-bordered">

        <thead class="thead-light">
        <tr>
            <th colspan="8">Nota detail</th>
        </tr>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tipe pembelian</th>
            <th scope="col">Barang</th>
            <th scope="col">Description</th>
            <th scope="col">Quantity</th>
            <th scope="col">Satuan</th>
            <th scope="col">Harga</th>
            <th scope="col" class="text-center"
                style="width: 2px"></th>
        </tr>
        </thead>
        <tbody class="container-rooms">
        <?php foreach ($modelsDetailDetail as $j => $modelDetailDetail): ?>
            <tr class="room-item">
                <td class="align-middle" style="width: 2px;">

                    <?php if (!$modelDetailDetail->isNewRecord) {
                        echo Html::activeHiddenInput($modelDetailDetail, "[$i][$j]id");
                    } ?>

                    <i class="bi bi-dash"></i>
                </td>

                <td><?= $form->field($modelDetailDetail, "[$i][$j]tipe_pembelian_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                        ->dropDownList(TipePembelian::find()->map());
                    ?>
                </td>
                <td><?= $form->field($modelDetailDetail, "[$i][$j]barang_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                        ->widget(Select2::class, [
                            'data' => Barang::find()->map(),
                            'options' => [
                                'placeholder' => '= Pilih barang ='
                            ]
                        ]); ?></td>
                <td><?= $form->field($modelDetailDetail, "[$i][$j]description", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?></td>
                <td><?= $form->field($modelDetailDetail, "[$i][$j]quantity", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?></td>
                <td><?= $form->field($modelDetailDetail, "[$i][$j]satuan_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])->widget(Select2::class, [
                        'data' => Satuan::find()->map(),
                        'options' => [
                            'prompt' => '= Pilih Salah Satu =',
                            'class' => 'satuan-id form-control',

                        ]
                    ]); ?></td>
                <td><?= $form->field($modelDetailDetail, "[$i][$j]harga", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
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
                    ?></td>

                <td class="text-center" style="width: 90px;">
                    <button type="button" class="remove-room btn btn-link text-danger">
                        <i class="bi bi-trash"> </i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td colspan="7"><?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah Detail Nota', ['class' => 'add-room btn btn-success',]); ?></td>
        </tr>
        </tfoot>

    </table>
<?php DynamicFormWidget::end(); ?>