<?php


/* @var $this View */
/* @var $model QuotationFormJob */

/* @var $quotation Quotation */

use app\models\Card;
use app\models\CardOwnEquipment;
use app\models\Quotation;
use app\models\QuotationFormJob;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>


<div class="quotation-form">
    <?php $form = ActiveForm::begin() ?>

    <div class="card rounded item">

        <div class="card-header d-flex justify-content-between">
            <?php if (!$model->isNewRecord) {
                echo Html::activeHiddenInput($model, "id");
            } ?>

            <?= Html::tag('span', 'Form Job', ['class' => 'fw-bold']) ?>
        </div>

        <div class="card-body">

            <div class="row row-cols-2 mb-2">

                <!-- Nomor Service -->
                <div class="col">
                    <div class="p-4 bg-info rounded-2 fw-bold h-100">
                        <span class="text-light">
                            Nomor Service:<br/> Auto Generate by Sistem
                        </span>
                    </div>
                </div>

                <!-- Person In Charge-->
                <div class="col">
                    <div class="p-4 bg-warning rounded-2 fw-bold h-100">
                        <h3 class="text-light">
                            <?= $model->quotation->customer->nama ?>
                        </h3>
                        <span><?= $model->quotation->suratPerintahKerjaSupportingDocument?->suratPerintahKerja?->nomor ?></span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row row-cols-2 align-items-end">

                <!-- SPK / SPK DOS -->
                <div class="col">
                    <?= $form->field($model, 'surat_perintah_kerja_dos')->textInput(['placeholder' => 'Isi nomor SPK dari DOS']) // From DOS       ?>
                </div>

                <!-- No Unit -->
                <div class="col">
                    <!-- Card Own Equipment -->
                    <?php $cardOwnEquipmentData = CardOwnEquipment::find()->byCardId($quotation->customer_id); ?>
                    <?php
                    $merkInputSelector = Html::getInputId($model, 'cardOwnEquipmentMerkType');
                    $prodInputSelector = Html::getInputId($model, 'cardOwnEquipmentProductionNo');
                    $urlCardOwnEquipmentDetail = Url::to(['quotation/find-card-own-equipment-detail']);

                    echo $form->field($model, "card_own_equipment_id")
                        ->widget(Select2::class, [
                            'data'         => $cardOwnEquipmentData,
                            'options'      => [
                                'placeholder' => '= Pilih unit dari Card Own Eq.  ='
                            ],
                            'pluginEvents' => [
                                /**
                                 * @see \app\controllers\QuotationController::actionFindCardOwnEquipmentDetail()
                                 * @see \app\models\active_queries\CardOwnEquipmentQuery::spec()
                                 *
                                 * Hasil query `merkType` akan di salin ke
                                 * ```
                                 * $form->field($model, "cardOwnEquipmentMerkType")->textInput(['disabled' => true])
                                 * ```
                                 * Hasil query `productionNo` akan di salin ke
                                 *
                                 * ```
                                 * $form->field($model, "cardOwnEquipmentProductionNo")->textInput(['disabled' => true])
                                 * ```
                                 *
                                 */
                                "change" => "function (e) {\n  
                                    var id = $(this).val();\n  
                                    var merkInput = document.getElementById('{$merkInputSelector}');\n  
                                    var prodInput = document.getElementById('{$prodInputSelector}');\n  
                                    
                                    function setVals(m, p){ 
                                        if(merkInput) merkInput.value = m || ''; 
                                        if(prodInput) prodInput.value = p || ''; }\n  
                                        if(!id){ setVals('', ''); 
                                        return; 
                                    }\n  
                                    
                                    jQuery.get('{$urlCardOwnEquipmentDetail}', { id: id })\n    
                                        .done(function(resp){\n      
                                            try { if (typeof resp === 'string') { 
                                                resp = JSON.parse(resp); } 
                                            } catch (err) {}\n      
                                                var merk = (resp && (resp.merkType || (resp.data && resp.data.merkType))) || '';\n      
                                                var prod = (resp && (resp.productionNo || (resp.data && resp.data.productionNo))) || '';\n      
                                                setVals(merk, prod);\n    
                                            })\n    
                                        .fail(function(){ 
                                            setVals('', ''); 
                                        });\n
                                    }"
                            ]
                        ])->label('No Unit')->hint('Jika unit tidak ditemukan, sebaiknya lengkapi dulu di menu Card Own Eq.') ?>
                </div>
            </div>

            <hr>

            <div class="row row-cols-2">

                <!-- Tanggal -->
                <div class="col">
                    <div class="p-4 bg-info rounded-2 fw-bold">
                        <span class="text-light">
                            No Quotation<br/><?= $model->quotation->nomor ?>
                        </span>
                    </div>
                </div>

                <div class="col">
                    <?= $form->field($model, "cardOwnEquipmentMerkType")->textInput(['disabled' => true]) ?>
                </div>

            </div>

            <hr>

            <div class="row row-cols-2">

                <!-- Tanggal -->
                <div class="col">
                    <?= $form->field($model, "tanggal")->widget(DatePicker::class); ?>
                </div>


                <div class="col">

                    <!-- Hour meter -->
                    <?= $form->field($model, "hour_meter"); ?>
                </div>


            </div>

            <hr>
            <div class="row row-cols-2">
                <div class="col">

                    <?= $form->field($model, "person_in_charge")->widget(Select2::class, [
                        'data' => Quotation::find()->attendanceList($quotation->id)
                    ])->label('PIC') ?>
                </div>

                <div class="col">
                    <?= $form->field($model, "cardOwnEquipmentProductionNo")->textInput(['disabled' => true]) ?>
                </div>
            </div>

            <hr>
            <div class="row row-cols-2">
                <div class="col">
                    <!-- Issue -->
                    <?= $form->field($model, "issue")->textarea([
                        'rows' => 4
                    ]); ?>
                </div>

                <div class="col">
                    <!-- Mekaniks ID -->
                    <?= $form->field($model, 'mekaniksId')->widget(Select2::class, [
                        'data'          => Card::find()->map(Card::GET_ONLY_MEKANIK),
                        'pluginOptions' => [
                            'multiple' => true
                        ],
                        'options'       => [
                            'placeholder' => 'Pilih mekanik - mekanik'
                        ]
                    ]); ?>
                </div>
            </div>
        </div>

        <div class="card-body"></div>
        <div class="card-body">
            <!-- Remarks -->
            <?= $form->field($model, "remarks")->textarea([
                'rows' => 4
            ]); ?>
        </div>

        <div class="card-footer p-3">
            <div class="d-flex justify-content-between">
                <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end() ?>
</div>