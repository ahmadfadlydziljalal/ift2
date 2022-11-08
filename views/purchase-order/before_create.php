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


$this->title = 'Tambah Purchase Order';
$this->params['breadcrumbs'][] = ['label' => 'Purchase Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="purchase-order-before-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>

    <?php /* @see \app\controllers\PurchaseOrderController::actionFindMaterialRequisitionForCreatePurchaseOrder() */ ?>
    <?= $form->field($model, 'nomorMaterialRequest')->widget(Select2::class, [
        'initValueText' => '',
        'options' => ['placeholder' => 'Search for a material request ...'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['find-material-requisition-for-create-purchase-order']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(TextLinkEnum::SEARCH->value, [
            'class' => 'btn btn-primary'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>