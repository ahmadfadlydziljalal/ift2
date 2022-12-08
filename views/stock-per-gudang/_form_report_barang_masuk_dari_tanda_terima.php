<?php


/* @var $this View */
/* @var string $initValueText */
/* @var string $urlPrint */
/* @var string $urlFind */
/* @var string $pagePrint */
/* @var $model ReportStockPerGudangBarangMasukDariTandaTerima */

/* @see \app\controllers\StockPerGudangController::actionCreateReportBarangMasuk() */

use app\enums\TextLinkEnum;
use app\models\form\ReportStockPerGudangBarangMasukDariTandaTerima;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap5\Html;
use yii\helpers\Inflector;
use yii\web\JsExpression;
use yii\web\View;

$this->title = 'Laporan Barang Masuk dari ' . Inflector::camel2words(Yii::$app->request->queryParams['modelName']);
$this->params['breadcrumbs'][] = ['label' => 'Stock Per Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="stock-per-gudang-form ">

    <h1><?= $this->title ?></h1>

    <div class="d-flex flex-column gap-3">
        <div class="form">
           <?php $form = ActiveForm::begin() ?>

           <?php try {
              echo $form->field($model, 'nomor')
                 ->widget(Select2::class, [
                    'initValueText' => $initValueText,
                    'options' => ['placeholder' => 'Cari nomor surat nya ...'],
                    'pluginOptions' => [
                       'allowClear' => true,
                       'minimumInputLength' => 3,
                       'language' => [
                          'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                       ],
                       'ajax' => [
                          /** @see \app\controllers\StockPerGudangController::actionFindTandaTerimaBarang() */
                          'url' => $urlFind,
                          'dataType' => 'json',
                          'data' => new JsExpression('function(params) { return {q:params.term}; }')
                       ],
                       'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                       'templateResult' => new JsExpression('function(city) { return city.text; }'),
                       'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                    ],
                 ]);
           } catch (Exception $e) {
              echo $e->getMessage();
           }
           ?>

            <div class="d-flex justify-content-between mt-3">
               <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
               <?= Html::submitButton(' Cari', ['class' => 'btn btn-primary']) ?>
            </div>

           <?php ActiveForm::end() ?>
        </div>


       <?php if (Yii::$app->request->isPost) : ?>
           <div>
               <h1>Result: </h1>
              <?= $this->render($pagePrint, [
                 'model' => $model->getModel()
              ]); ?>

              <?= Html::a(TextLinkEnum::PRINT->value, $urlPrint, [
                 'target' => '_blank',
                 'class' => 'btn btn-primary'
              ]) ?>
           </div>
       <?php endif ?>

    </div>


</div>