<?php

use app\models\Quotation;
use kartik\datecontrol\DateControl;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\SuratPerintahKerja */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="surat-perintah-kerja-form">

    <?php $form = ActiveForm::begin([]); ?>

    <div class="row">
        <div class="col-12 col-lg-8">

            <?= $form->field($model, 'tanggal')->widget(DateControl::class, [
                'type'    => DateControl::FORMAT_DATE,
                'options' => [
                    'autofocus' => 'autofocus'
                ]
            ]) ?>
            <?= $form->field($model, 'pelaksana')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'judul')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>



            <?php

            echo $form->field($model, 'quotationPendukung')
                ->widget(Select2::class, [
                    'options'       => [
                        'multiple'    => true,
                        'placeholder' => 'Cari by nomor quotation...'
                    ],
                    'initValueText' => $model->isNewRecord ? null : Quotation::find()->where(['IN', 'id', $model->quotationPendukung])->select('nomor')->column(),
                    'pluginOptions' => [
                        'allowClear'         => true,
                        'minimumInputLength' => 3,
                        'language'           => [
                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                        ],
                        'ajax'               => [
                            'url'      => Url::to(['find-quotation']), /* @see \app\controllers\SuratPerintahKerjaController::actionFindQuotation() */
                            'dataType' => 'json',
                            'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
                            'delay'    => 1000
                        ],
                        'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                        'templateResult'     => new JsExpression('function(result) { return result.text; }'),
                        'templateSelection'  => new JsExpression('function (result) { return result.text; }'),
                    ],
                ]);
            ?>

            <?= $form->field($model, 'data_pendukung_lainnya')->textarea(['rows' => 6]) ?>

            <div class="d-flex mt-3 justify-content-between">
                <?= Html::a(' Tutup', ['index'], [
                    'class' => 'btn btn-secondary',
                    'type'  => 'button'
                ]) ?>
                <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>

            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>