<?php


/* @var $this View */
/* @var $models array */

/* @var $quotation Quotation */

use app\enums\TextLinkEnum;
use app\models\Quotation;
use kartik\form\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\web\View;

?>

<div class="quotation-form">
    <?php $form = ActiveForm::begin([
        'id' => 'dynamic-form'
    ]) ?>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.item',
        'limit' => 100,
        'min' => 1,
        'insertButton' => '.add-item',
        'deleteButton' => '.remove-item',
        'model' => $models[0],
        'formId' => 'dynamic-form',
        'formFields' => ['id', 'term_and_condition'],
    ]); ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 2px">#</th>
                <th>Term & Condition</th>
                <th style="width: 2px">Aksi</th>
            </tr>
            </thead>

            <tbody class="container-items">

            <?php foreach ($models as $i => $model) : ?>
                <tr class="item">
                    <td>
                        <?php if (!$model->isNewRecord) {
                            echo Html::activeHiddenInput($model, "[$i]id");
                        } ?>
                        <i class="bi bi-arrow-right-short"></i>
                    </td>

                    <td>
                        <?= $form->field($model, "[$i]term_and_condition", ['template' =>
                            '{input}{error}{hint}', 'options' => ['class' => null]])->textInput() ?>
                    </td>
                    <td>
                        <?= Html::button('<i class="bi bi-trash"> </i>', [
                            'class' => 'btn btn-link remove-item text-danger'
                        ]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

            <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <?php echo Html::button(TextLinkEnum::TAMBAH->value, ['class' => 'add-item btn btn-primary']); ?>
                </td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>

    <?php DynamicFormWidget::end() ?>


    <div class="d-flex justify-content-between">
        <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>