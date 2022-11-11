<?php


/* @var $this View */
/* @see \app\controllers\PurchaseOrderController::actionBeforeCreate() */

/* @var $model BeforeCreatePurchaseOrderForm */

use app\enums\TextLinkEnum;
use app\models\form\BeforeCreatePurchaseOrderForm;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;


$this->title = 'Membuat Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="purchase-order-before-create">

    <h1>Langkah 1</h1>

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_INLINE,
        'fieldConfig' => ['options' => ['class' => 'form-group mr-2 me-2']]
    ]) ?>

    <?php /* @see \app\controllers\PurchaseOrderController::actionFindMrForCreatePo() */ ?>
    <?= $form->field($model, 'nomorMaterialRequest')->widget(Select2::class, [
        'initValueText' => '',
        'options' => ['placeholder' => 'Cari nomor material request yang sudah ada penawaran harga dengan status disetujui'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['purchase-order/find-mr-for-create-po']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
        ],
    ]); ?>

    <?= Html::submitButton(TextLinkEnum::SEARCH->value, [
        'class' => 'btn btn-primary'
    ]) ?>

    <?php ActiveForm::end(); ?>
</div>