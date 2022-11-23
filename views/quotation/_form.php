<?php

use app\models\Card;
use app\models\MataUang;
use app\models\Rekening;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Quotation */
/* @var $form yii\bootstrap5\ActiveForm */
?>

    <div class="quotation-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="card">
            <div class="card-body">

                <div class="d-flex flex-column gap-3">
                    <div class="py-3 d-flex flex-row gap-5 align-items-center fw-bold">
                        <div style="min-width: 12rem">
                            <i class="bi bi-clock-history"></i> General
                        </div>

                        <div class="flex-grow-1 border border-3">

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-3">
                            <?= $form->field($model, 'mata_uang_id')->dropDownList(MataUang::find()->map()) ?>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <?= $form->field($model, 'tanggal')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <?= $form->field($model, 'tanggal_batas_valid')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <?= $form->field($model, "vat_percentage") ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <?= $form->field($model, 'rekening_id')->dropDownList(Rekening::find()->mapOnlyTokoSaya()) ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3">
                    <div class="py-3 d-flex flex-row gap-5 align-items-center fw-bold">
                        <div style="min-width: 12rem">
                            <i class="bi bi-person-badge"></i> Data Customer
                        </div>
                        <div class="flex-grow-1 border border-3">

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <?= $form->field($model, 'customer_id')->widget(Select2::class, [
                                'data' => Card::find()->map(),
                                'options' => [
                                    'prompt' => '= Pilih salah satu ='
                                ]
                            ]) ?>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 mt-4">
                            <?= Html::a('Cari Attendant', ['card/find-pic-as-attendant'], [
                                'class' => 'btn btn-primary find-attendant'
                            ]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <?= $form->field($model, 'attendant_1')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <?= $form->field($model, 'attendant_phone_1')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <?= $form->field($model, 'attendant_email_1')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <?= $form->field($model, 'attendant_2')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <?= $form->field($model, 'attendant_phone_2')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <?= $form->field($model, 'attendant_email_2')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column gap-3">
                    <div class="py-3 d-flex flex-row gap-5 align-items-center fw-bold">
                        <div style="min-width: 12rem">
                            <i class="bi bi-person-badge"></i> Data Kantor IFT
                        </div>
                        <div class="flex-grow-1 border border-3">

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <?= $form->field($model, 'signature_orang_kantor_id')->widget(Select2::class, [
                                'data' => Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR),
                                'options' => [
                                    'prompt' => '= Pilih salah satu ='
                                ]
                            ]) ?>
                        </div>

                    </div>
                </div>


            </div>

            <div class="card-footer border-top p-3">
                <div class="d-flex justify-content-between">
                    <?= Html::a(' Tutup', ['index'], [
                        'class' => 'btn btn-secondary',
                        'type' => 'button'
                    ]) ?>
                    <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php

$js = <<<JS
    jQuery(function(){

        let quotationAttendant1 = jQuery("#quotation-attendant_1");
        let quotationAttendantPhone1 = jQuery("#quotation-attendant_phone_1");
        let quotationAttendantEmail1 = jQuery("#quotation-attendant_email_1");

        let quotationAttendant2 = jQuery("#quotation-attendant_2");
        let quotationAttendantPhone2 = jQuery("#quotation-attendant_phone_2");
        let quotationAttendantEmail2 = jQuery("#quotation-attendant_email_2");
    
        let url = '';
        let quotationCustomerId = jQuery('#quotation-customer_id');
        jQuery(".find-attendant").click(function(e){
            
            e.preventDefault();
            
            quotationAttendant1.val('');
            quotationAttendantPhone1.val('');
            quotationAttendantEmail1.val('');

            quotationAttendant2.val('');
            quotationAttendantPhone2.val('');
            quotationAttendantEmail2.val('');

            url = jQuery(this).attr('href');
            customerIdVal = quotationCustomerId.val();

            jQuery.post(url, {'customerId' : customerIdVal}, function(response){
                jQuery.each(response, function(k, v){         
                    if(k > 1){
                        return false;
                    }

                    var key = k + 1;
                    
                    jQuery('#quotation-attendant_'+ key).val(v.nama);
                    jQuery('#quotation-attendant_phone_'+ key).val(v.telepon);
                    jQuery('#quotation-attendant_email_'+ key).val(v.email);

                });
            });            
        });
    });
JS;

$this->registerJs($js);