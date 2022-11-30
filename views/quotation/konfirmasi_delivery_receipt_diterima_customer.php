<?php

use app\models\Quotation;
use app\models\QuotationDeliveryReceipt;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;


/* @var $this View */
/* @var $quotation Quotation|null */
/* @var $model QuotationDeliveryReceipt|null */
/* @see \app\controllers\QuotationController::actionKonfirmasiDiterimaCustomer() */

$this->title = 'Konfirmasi oleh customer: ' . $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $quotation->nomor, 'url' => ['view', 'id' => $quotation->id]];
$this->params['breadcrumbs'][] = 'Konfirmasi';

?>

<div class="quotation-form">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-6 col-sm-12 col-md-6">
           <?= GridView::widget([
              'dataProvider' => new ActiveDataProvider([
                 'query' => $model->getQuotationDeliveryReceiptDetails(),
                 'pagination' => false,
                 'sort' => false
              ]),
              'layout' => '{items}',
              'columns' => [
                 [
                    'class' => SerialColumn::class
                 ],
                 //'id',
                 [
                    'class' => DataColumn::class,
                    'header' => 'Barang',
                    'value' => 'quotationBarang.barang.nama'
                 ],
                 [
                    'class' => DataColumn::class,
                    'value' => 'quotationBarang.quantity',
                    'header' => 'Quotation Qty'
                 ],
                 [
                    'class' => DataColumn::class,
                    'attribute' => 'quantity',
                    'value' => 'quantity',
                    'header' => 'Qty Dikirim'
                 ],
              ]
           ]) ?>
        </div>
        <div class="col-6 col-sm-12 col-md-6">
           <?php $form = ActiveForm::begin() ?>
           <?= $form->field($model, 'tanggal_konfirmasi_diterima_customer')->widget(DateControl::class, [
              'type' => DateControl::FORMAT_DATE
           ]) ?>
            <div class="d-flex justify-content-between">
               <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
               <?= Html::submitButton(' Konfirmasi', ['class' => 'btn btn-success']) ?>
            </div>

           <?php ActiveForm::end() ?>
        </div>
    </div>


</div>