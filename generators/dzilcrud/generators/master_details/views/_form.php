<?php

use rmrevin\yii\fontawesome\FAS;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator \app\generators\dzilcrud\generators\Generator */

/* @var $model ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $modelsDetail <?= ltrim($generator->modelsClassDetail, '\\') ?> */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin([
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
                    <?php foreach ($generator->getColumnNames() as $key => $attribute) {
                        if (in_array($attribute, ['created_at', 'updated_at', 'created_by', 'updated_by'])) {
                            continue;
                        }

                        if (in_array($attribute, $safeAttributes)) {
                            if ($key == 1) {
                                echo "<?= " . $generator->generateActiveFieldAutoFocus($attribute) . " ?>\n";
                            } else {
                                echo "            <?= " . $generator->generateActiveField($attribute) . " ?>\n";
                            }
                        }
                    } ?>
                </div>
            </div>
        </div>

        <div class="form-detail">

            <?= "<?php \n" ?>
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
                'formFields' => [<?php foreach ($generator->getDetailColumnNames() as $columnName) {
                    echo " '" . $columnName . "', ";
                } ?>],
                ]);
            ?>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <?php
                        $colspan = 0;
                        foreach ($generator->getDetailColumnNames() as $columnName) {
                            if ($columnName === 'id') continue;
                            if ($columnName === Inflector::underscore(StringHelper::basename($generator->modelClass)) . '_id') continue;
                            $colspan += 1;
                            ?><?php } ?><th colspan="<?= $colspan + 2 ?>"><?= Inflector::titleize(StringHelper::basename($generator->modelsClassDetail)) ?></th>
                    </tr>
                    <tr>
                        <th scope="col">#</th>
                        <?php foreach ($generator->getDetailColumnNames() as $columnName) {
                            if ($columnName === 'id') continue;
                            if ($columnName === Inflector::underscore(StringHelper::basename($generator->modelClass)) . '_id') continue;
                            ?><th scope="col"><?= Inflector::humanize($columnName) ?></th>
                        <?php } ?><th scope="col" style="width: 2px">Aksi</th>
                    </tr>
                    </thead>

                    <tbody class="container-items">

                    <?= "<?php " ?>foreach ($modelsDetail as $i => $modelDetail): ?>
                    <tr class="item">

                        <td style="width: 2px;" class="align-middle">
                            <?= "<?php " ?>if (!$modelDetail->isNewRecord) {
                            echo Html::activeHiddenInput($modelDetail, "[$i]id");
                            } ?>
                            <i class="bi bi-arrow-right-short"></i>
                        </td>

                        <?php foreach ($generator->getDetailColumnNames() as $columnName) {
                            if ($columnName === 'id') continue;
                            if ($columnName === Inflector::underscore(StringHelper::basename($generator->modelClass)) . '_id') continue;
                            ?><td><?= "<?= " ?>$form->field($modelDetail, "[$i]<?= $columnName ?>", ['template' =>
                            '{input}{error}{hint}', 'options' =>['class' => null] ]); ?></td>
                        <?php } ?>

                        <td>
                            <button type="button" class="remove-item btn btn-link text-danger">
                                <i class="bi bi-trash"> </i>
                            </button>
                        </td>
                    </tr>
                    <?= "<?php " ?>endforeach; ?>

                    </tbody>

                    <tfoot>
                    <tr>
                        <td class="text-end" colspan="<?= $colspan + 1 ?>">
                            <?= "<?php echo " ?>Html::button('<span class="bi bi-plus-circle"></span> Tambah', [ 'class' => 'add-item btn btn-success', ]); ?>
                        </td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <?= "<?php DynamicFormWidget::end(); ?> \n" ?>
        </div>

        <div class="d-flex justify-content-between">
            <?= "<?= " ?>Html::a(<?= $generator->generateString(' Tutup') ?>, ['index'], ['class' => 'btn btn-secondary']) ?>
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString(' Simpan') ?>, ['class' =>'btn btn-success'])?>
        </div>
    </div>

    <?= "<?php ActiveForm::end();  ?> " ?>


</div>