<?php


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
/* @var $modelsDetailDetail <?= ltrim($generator->modelsClassDetailDetail, '\\') ?> */
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
                                echo "    <?= " . $generator->generateActiveFieldAutoFocus($attribute) . " ?>\n";
                            } else {
                                echo "<?php echo " . $generator->generateActiveField($attribute) . "; ?>\n\t";
                            }
                        }
                    } ?>
                </div>
            </div>
        </div>

        <div class="form-detail">

            <?= "<?php " ?>DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 100, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsDetail[0],
                'formId' => 'dynamic-form',
                'formFields' => [<?php foreach ($generator->getDetailColumnNames() as $columnName) {
                    echo " '" . $columnName . "', ";
                } ?>],
            ]); ?>
            <?php $detail = ucwords(Inflector::titleize(Inflector::pluralize(StringHelper::basename($generator->modelsClassDetail)))) ?>

            <div class="container-items">

                <?= "<?php " ?>foreach ($modelsDetail as $i => $modelDetail): ?>
                <div class="card mb-4 item">

                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <?= "<?php " ?>if (!$modelDetail->isNewRecord) { echo Html::activeHiddenInput($modelDetail, "[$i]id"); } ?>
                            <strong><i class="bi bi-arrow-right-short"></i> <?= $detail ?></strong>
                            <button type="button" class="remove-item btn btn-link text-danger"><i class="bi bi-x-circle"> </i></button></div>
                    </div>

                    <div class="card-body">
                        <?php foreach ($generator->getDetailColumnNames() as $columnName) {
                            if ($columnName === 'id') continue;
                            if ($columnName === Inflector::underscore(StringHelper::basename($generator->modelClass)) . '_id') continue;
                            ?><?= "<?= " ?>$form->field($modelDetail, "[$i]<?= $columnName ?>", ['options' =>['class' => 'mb-3 row'] ]); ?>
                        <?php } ?>
                    </div>

                    <?= "<?= " ?>$this->render('_form-detail-detail', [
                                'form' => $form,
                                'i' => $i,
                                'modelsDetailDetail' => $modelsDetailDetail[$i],
                    ]) ?>

                </div>

                <?= "<?php " ?>endforeach; ?>
            </div>

            <div class="text-end">
                <?= "<?php echo " ?>Html::button('<span class="bi bi-plus-circle"></span> Tambah <?= lcfirst($detail) ?>', [ 'class' => 'add-item btn btn-success', ]); ?>
            </div>

            <?= "<?php DynamicFormWidget::end(); ?> \n" ?>

            <div class="d-flex justify-content-between mt-3">
                <?= "<?= " ?>Html::a( <?= $generator->generateString(' Tutup') ?>, ['index'], ['class' => 'btn btn-secondary']) ?>
                <?= "<?= " ?>Html::submitButton(<?= $generator->generateString(' Simpan') ?>, ['class' =>'btn btn-primary' ]) ?>
            </div>
        </div>

        <?= "<?php ActiveForm::end();  ?> " ?>

    </div>