<?php

use app\models\Card;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\base\Widget;
use yii\bootstrap5\Html;
use yii\web\View;


/* @var $this View */
/* @var $form ActiveForm|Widget */
/* @var $i int|string */
/* @var $modelsDetailDetail mixed */

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
   'formFields' => ['id', 'card_id', 'block', 'rak', 'tier', 'row'],
]); ?>

    <table class="table table-bordered m-0 p-0">

        <thead class="thead-light">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Warehouse</th>
            <th scope="col">Quantity</th>
            <th scope="col">Block</th>
            <th scope="col">Rak</th>
            <th scope="col">Tier</th>
            <th scope="col">Row</th>
            <th scope="col">Catatan</th>
            <th scope="col" style="width:2px"></th>
        </tr>
        </thead>
        <tbody class="container-rooms">

        <?php foreach ($modelsDetailDetail as $j => $modelDetailDetail): ?>
            <tr class="room-item">

                <td class="column-tipe-pembelian">

                   <?php if (!$modelDetailDetail->isNewRecord) {
                      echo Html::activeHiddenInput($modelDetailDetail, "[$i][$j]id");
                   } ?>
                    <i class="bi bi-arrow-right-short"></i>
                </td>

                <td>
                   <?= $form->field($modelDetailDetail, "[$i][$j]card_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                      ->dropDownList(Card::find()->map(Card::GET_ONLY_WAREHOUSE)); ?>
                </td>

                <td>
                   <?= $form->field($modelDetailDetail, "[$i][$j]quantity", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                      'type' => 'number',
                      'class' => 'form-control'
                   ]); ?>
                </td>

                <td>
                   <?= $form->field($modelDetailDetail, "[$i][$j]block", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                </td>

                <td>
                   <?= $form->field($modelDetailDetail, "[$i][$j]rak", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                </td>

                <td>
                   <?= $form->field($modelDetailDetail, "[$i][$j]tier", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                </td>

                <td>
                   <?= $form->field($modelDetailDetail, "[$i][$j]row", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                </td>
                <td>
                   <?= $form->field($modelDetailDetail, "[$i][$j]catatan", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]]); ?>
                </td>

                <td class="text-center" style="width: 2px;">
                    <button type="button" class="remove-room btn btn-link text-danger px-2">
                        <i class="bi bi-trash"> </i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>

            <td colspan="8"
                class="text-end">
               <?= Html::button('<span class="bi bi-plus-circle"></span> Tambah Lokasi', [
                  'class' => 'add-room btn btn-success',
               ]);
               ?>
            </td>
            <td></td>
        </tr>
        </tfoot>

    </table>
<?php DynamicFormWidget::end(); ?>