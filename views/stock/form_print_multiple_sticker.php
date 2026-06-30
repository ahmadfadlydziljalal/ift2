<?php

/* @var $this View */

/* @var $model PrintStockMultipleStickerForm */

/* @see \app\controllers\StockController::actionPrintMultipleSticker() */

use app\models\form\PrintStockMultipleStickerForm;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

$this->title = "Print Multiple Sticker";
$this->params['breadcrumbs'][] = ['label' => 'Stock', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class=" d-flex flex-column gap-2">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'no-submit-disable'],
        'method'  => 'post',
    ]); ?>

    <?= $form->field($model, 'format')->dropDownList($model->getFormatOptions()) ?>
    <?= $form->field($model, 'orientation')->dropDownList($model->getOrientationOptions()) ?>
    <?= $form->field($model, "partNumbers")
        ->widget(Select2::class, [
            'options'       => [
                'placeholder' => '...'
            ],
            'theme'         => Select2::THEME_CLASSIC,
            'pluginOptions' => [
                'multiple'           => true,
                'allowClear'         => true,
                'minimumInputLength' => 3,
                'language'           => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],
                'ajax'               => [
                    'url'      => Url::to(['find-barang']), /* @see \app\controllers\StockController::actionFindBarang() */
                    'dataType' => 'json',
                    'data'     => new JsExpression('function(params) { return { q:params.term, id: params.id } }'),
                    'delay'    => 1000
                ],
                'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                'templateResult'     => new JsExpression('function(result) { return result.text; }'),
                'templateSelection'  => new JsExpression('function (result) { return result.text; }'),
                'width'              => '100%',
            ],
        ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Cetak', ['class' => 'btn btn-primary', 'formtarget' => '_blank', 'name' => 'print-multiple-sticker-form-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>