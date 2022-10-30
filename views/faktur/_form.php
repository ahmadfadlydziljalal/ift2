<?php

use app\components\helpers\ArrayHelper;
use app\models\Card;
use app\models\JenisTransaksi;
use app\models\Rekening;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Faktur */
/* @var $modelsDetail app\models\FakturDetail */
/* @var $form yii\bootstrap5\ActiveForm */

?>

    <div class="faktur-form">

        <?php $form = ActiveForm::begin([
            'id' => 'dynamic-form',
            'enableClientValidation' => true
        ]); ?>

        <div class="d-flex flex-column mt-0" style="gap: 1rem">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <?= $form->field($model, 'toko_saya_id')->widget(Select2::class, [
                                'data' => Card::find()->map(Card::GET_ONLY_TOKO_SAYA),
                                'options' => [
                                    'prompt' => '= Pilih Toko =',
                                    'autofocus' => 'autofocus'
                                ],
                            ]) ?>
                        </div>

                        <div class="col-12 col-lg-3">
                            <?= $form->field($model, 'card_id')->widget(Select2::class, [
                                'data' => Card::find()->map(Card::GET_APART_FROM_TOKO_SAYA),
                                'options' => [
                                    'prompt' => '= Pilih Customer =',
                                    'autofocus' => 'autofocus'
                                ],
                            ])->label('Customer') ?>
                        </div>

                        <div class="col-12 col-lg-3">
                            <?= $form->field($model, 'tanggal_faktur')->widget(DateControl::class, [
                                'type' => kartik\datecontrol\DateControl::FORMAT_DATE,

                            ]) ?>
                        </div>
                        <div class="col-12 col-lg-3">
                            <?= $form->field($model, 'nomor_purchase_order')->textInput(['maxlength' => true]) ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <?= $form->field($model, 'jenis_transaksi_id', ['inline' => true])->radioList(ArrayHelper::map(
                                JenisTransaksi::find()->all(),
                                'id',
                                'nama'
                            )) ?>
                        </div>

                        <div class="col-12 col-lg-3">
                            <?= $form->field($model, 'rekening_id', ['inline' => true])->radioList(Rekening::find()->map()) ?>
                        </div>
                    </div>
                </div>
            </div>

            <?= $this->render('_form_detail', ['form' => $form, 'model' => $model, 'modelsDetail' => $modelsDetail]) ?>

            <div class="d-flex justify-content-between">
                <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
                <div>
                    <?= Html::submitButton(' Simpan & Buat Faktur Lainnya', [
                        'class' => 'btn btn-success',
                        'name' => 'create-another',
                        'value' => 'true'
                    ]) ?>
                    <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
                </div>

            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php
$afterInsert = <<<JS
    jQuery('#faktur-toko_saya_id').select2('open');
    jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
        var barangId = jQuery(item).find('.barang-id');
        barangId.val('').trigger('change');
      
        var satuanId = jQuery(item).find('.satuan-id');
        satuanId.empty();
    });
JS;

$this->registerJs($afterInsert);