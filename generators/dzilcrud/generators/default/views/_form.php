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

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin([

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

    <div class="row">
        <div class="col-12 col-lg-8">

        <?php foreach ($generator->getColumnNames() as $key => $attribute) {
            if (in_array($attribute, ['created_at', 'updated_at', 'created_by', 'updated_by'])) {
                continue;
            }
            if (in_array($attribute, $safeAttributes)) {
                if ($key == 1) {
                    echo "    <?= " . $generator->generateActiveFieldAutoFocus($attribute) . "?>\n";
                } else {
                    echo "           <?= " . $generator->generateActiveField($attribute) . " ?>\n";
                }
            }
        } ?>

            <div class="d-flex mt-3 justify-content-between">
                <?= "<?= " ?>Html::a(<?= $generator->generateString(' Tutup') ?>, ['index'], [
                    'class' => 'btn btn-secondary',
                    'type' => 'button'
                ]) ?>
                <?= "<?= " ?>Html::submitButton(<?= $generator->generateString(' Simpan') ?>, ['class' =>'btn btn-success' ]) ?>

            </div>
        </div>
    </div>



    <?= "<?php " ?>ActiveForm::end(); ?>

</div>