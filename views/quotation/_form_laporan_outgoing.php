<?php

use app\enums\TextLinkEnum;
use app\models\form\LaporanOutgoingQuotation;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;


/* @var $this View */
/* @var $model LaporanOutgoingQuotation */
/* @see \app\controllers\QuotationController::actionLaporanOutgoing() */

$this->title = 'Laporan Outgoing';
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="tanda-terima-barang-laporan">

    <h1><?= $this->title ?></h1>

   <?php $form = ActiveForm::begin() ?>

   <?= $form->field($model, 'tanggal')->widget(DatePicker::class) ?>

   <?= Html::submitButton(TextLinkEnum::SEARCH->value, [
      'class' => 'btn btn-primary'
   ]) ?>

   <?php ActiveForm::end() ?>
</div>