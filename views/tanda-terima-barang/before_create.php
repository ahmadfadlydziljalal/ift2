<?php


/* @var $this View */
/* @see \app\controllers\TandaTerimaBarangController::actionBeforeCreate() */

/* @var $model BeforeCreateTandaTerimaBarangForm */

use app\enums\TextLinkEnum;
use app\models\form\BeforeCreateTandaTerimaBarangForm;
use app\models\PurchaseOrder;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;


$this->title = 'Membuat Tanda Terima Barang';
$this->params['breadcrumbs'][] = ['label' => 'Tanda Terima Barang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="tanda-terima-form">

    <h1>Membuat Tanda Terima</h1>

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_INLINE,
        'fieldConfig' => ['options' => ['class' => 'form-group mr-2 me-2']]
    ]) ?>

    <?= $form->field($model, 'nomorPurchaseOrder')->widget(Select2::class, [
        'data' => PurchaseOrder::find()->mapListForCreateTandaTerima(),
        'options' => ['placeholder' => 'Cari nomor purchase order yang belum terbit tanda terima'],
    ]); ?>

    <?= Html::submitButton(TextLinkEnum::SEARCH->value, [
        'class' => 'btn btn-primary'
    ]) ?>

    <?php ActiveForm::end() ?>
</div>