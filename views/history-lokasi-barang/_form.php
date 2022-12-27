<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\HistoryLokasiBarang */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="history-lokasi-barang-form">

    <?php $form = ActiveForm::begin([

        'layout' => ActiveForm::LAYOUT_HORIZONTAL,
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4 col-form-label',
                'offset' => 'offset-sm-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ],
        ],

        /*'layout' => ActiveForm::LAYOUT_FLOATING,
            'fieldConfig' => [
            'options' => [
            'class' => 'form-floating'
            ]
        ]*/

    ]); ?>

    <div class="row">
        <div class="col-12 col-lg-8">

            <?= $form->field($model, 'nomor')->textInput([
                    'maxlength' => true,
                    'autofocus'=> 'autofocus'
                ])?>
           <?= $form->field($model, 'card_id')->textInput() ?>
           <?= $form->field($model, 'tanda_terima_barang_detail_id')->textInput() ?>
           <?= $form->field($model, 'claim_petty_cash_nota_detail_id')->textInput() ?>
           <?= $form->field($model, 'quotation_delivery_receipt_detail_id')->textInput() ?>
           <?= $form->field($model, 'tipe_pergerakan_id')->textInput() ?>
           <?= $form->field($model, 'step')->textInput() ?>
           <?= $form->field($model, 'quantity')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'block')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'rak')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'tier')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'row')->textInput(['maxlength' => true]) ?>
           <?= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>
           <?= $form->field($model, 'depend_id')->textInput() ?>

            <div class="d-flex mt-3 justify-content-between">
                <?= Html::a(' Tutup', ['index'], [
                    'class' => 'btn btn-secondary',
                    'type' => 'button'
                ]) ?>
                <?= Html::submitButton(' Simpan', ['class' =>'btn btn-success' ]) ?>

            </div>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>