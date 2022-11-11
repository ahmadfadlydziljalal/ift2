<?php

use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $i int|string */
/* @var $model app\models\TandaTerimaBarang */
/* @var $modelsDetail app\models\MaterialRequisitionDetailPenawaran */
/* @var $modelsDetailDetail app\models\TandaTerimaBarangDetail */
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
    'formFields' => ['id', 'material_requisition_detail_penawaran_id', 'tanggal', 'quantity_terima',],
]); ?>

    <table class="table table-bordered">

        <thead class="thead-light">
        <tr>
            <td colspan="4" class="fw-light">Penerimaan Barang</td>
        </tr>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tanggal</th>
            <th scope="col" class="text-end">Quantity terima</th>
            <th scope="col" class="text-center"
                style="width: 2px">

            </th>
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

                <td><?= $form->field($modelDetailDetail, "[$i][$j]tanggal", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                        ->widget(DatePicker::class)
                    ?>
                </td>
                <td><?= $form->field($modelDetailDetail, "[$i][$j]quantity_terima", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                        'class' => 'form-control quantity text-end',
                        'type' => 'number'
                    ]) ?></td>

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
            <th></th>
            <th colspan="3" class="text-end">
                <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-room btn btn-success',]); ?>
            </th>
        </tr>
        </tfoot>

    </table>
<?php DynamicFormWidget::end(); ?>