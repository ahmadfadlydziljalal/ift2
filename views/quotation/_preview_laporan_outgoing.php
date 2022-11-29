<?php

use app\enums\TextLinkEnum;
use app\models\form\LaporanOutgoingQuotation;
use kartik\export\ExportMenu;
use kartik\grid\DataColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap5\Html;
use yii\data\ArrayDataProvider;
use yii\web\View;

/* @var $this View */
/* @var $model LaporanOutgoingQuotation */

$this->title = $model->tanggal;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Laporan Outgoing', 'url' => ['laporan-outgoing']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="preview-data">
    <h1>Laporan Pengiriman Barang: <?= $model->tanggal ?></h1>
    <div class=" d-flex flex-column gap-2">
        <div class="d-flex flex-row gap-2">
           <?= Html::a(TextLinkEnum::LIST->value, ['quotation/index'], ['class' => 'btn btn-primary']) ?>
           <?php
           $dataProvider = new ArrayDataProvider([
              'allModels' => $model->getData(),
              'pagination' => false,
              'sort' => false
           ]);
           $gridColumns = [
              ['class' => SerialColumn::class],
              [
                 'class' => DataColumn::class,
                 'attribute' => 'barangNama',
                 'header' => 'Nama Barang',
                 'contentOptions' => [
                    'class' => 'text-start'
                 ]
              ],
              [
                 'class' => DataColumn::class,
                 'attribute' => 'satuanNama',
                 'header' => 'Satuan',
                 'contentOptions' => [
                    'class' => 'text-start'
                 ]
              ],
              [
                 'class' => DataColumn::class,
                 'attribute' => 'quotationBarangQuantity',
                 'header' => 'Quantity di perjanjian',
                 'contentOptions' => [
                    'class' => 'text-end'
                 ],
                 'headerOptions' => [
                    'class' => 'text-end'
                 ]
              ],
              [
                 'class' => DataColumn::class,
                 'attribute' => 'quantity',
                 'header' => 'Quantity yang dikirim',
                 'contentOptions' => [
                    'class' => 'text-end'
                 ],
                 'headerOptions' => [
                    'class' => 'text-end'
                 ]
              ],
              [
                 'class' => DataColumn::class,
                 'attribute' => 'totalQuantityIndent',
                 'header' => 'Total Indent',
                 'contentOptions' => [
                    'class' => 'text-end'
                 ],
                 'headerOptions' => [
                    'class' => 'text-end'
                 ]
              ],
           ];
           ?>
           <?php
           echo ExportMenu::widget([
              'dataProvider' => $dataProvider,
              'columns' => $gridColumns,
              'filename' => 'Laporan Outgoing Barang tanggal ' . $model->tanggal,
              'exportConfig' => [
                 ExportMenu::FORMAT_TEXT => false,
                 ExportMenu::FORMAT_HTML => false,
                 ExportMenu::FORMAT_PDF => [
                    'pdfConfig' => [
                       'methods' => [
                          'SetHeader' => ['Laporan Outgoing Barang tanggal ' . $model->tanggal],
                          'SetFooter' => ['{PAGENO}'],
                       ]
                    ],
                 ],
              ]
           ]);
           ?>
        </div>
       <?= GridView::widget([
          'dataProvider' => $dataProvider,
          'columns' => $gridColumns,
       ]);
       ?>
    </div>
</div>