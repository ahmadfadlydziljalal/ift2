<?php


/* @var $this View */
/* @var $model QuotationFormJob */

/* @var $quotation Quotation */

use app\models\Card;
use app\models\CardOwnEquipment;
use app\models\Quotation;
use app\models\QuotationFormJob;
use app\models\SuratPerintahKerja;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
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
                    </div>
                </div>
            </div>

            <hr>

            <div class="row row-cols-2 align-items-end">

                <!-- SPK / SPK DOS -->
                <div class="col">
                    <?php
                    // Tentukan state awal berdasarkan nilai model yang sudah ada
                    $hasWeb = !empty($model->surat_perintah_kerja_id);
                    $hasDos = !empty($model->surat_perintah_kerja_dos);
                    $initial = $hasWeb ? 'web' : ($hasDos ? 'dos' : 'web');

                    // Ambil ID input untuk dipakai di JS
                    $inputIdWeb = Html::getInputId($model, 'surat_perintah_kerja_id');
                    $inputIdDos = Html::getInputId($model, 'surat_perintah_kerja_dos');
                    ?>

                    <div class="mb-3">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                Pilih Sumber SPK: <span
                                        id="spk-source-label"><?= $initial === 'web' ? 'From Web' : 'From DOS' ?></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item spk-source-choose" href="#" data-mode="web">From Web</a>
                                </li>
                                <li><a class="dropdown-item spk-source-choose" href="#" data-mode="dos">From DOS</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-block">
                        <div id="spk-web-wrapper" class="me-3 <?= $initial === 'dos' ? 'd-none' : '' ?>">
                            <?= $form->field($model, 'surat_perintah_kerja_id')
                                ->hint('Silahkan pilih surat perintah kerja dengan benar')
                                ->widget(Select2::class, [
                                    'options'       => [
                                        'multiple'    => true,
                                        'placeholder' => 'Cari by nomor'
                                    ],
                                    'initValueText' => $model->isNewRecord ? null : (!empty($model->surat_perintah_kerja_id) ? SuratPerintahKerja::findOne($model->surat_perintah_kerja_id)->nomor : null),
                                    'pluginOptions' => [
                                        'allowClear'         => true,
                                        'minimumInputLength' => 3,
                                        'language'           => [
                                            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                                        ],
                                        'ajax'               => [
                                            'url'      => Url::to(['find-surat-perintah-kerja']), /* @see \app\controllers\QuotationController::actionFindSuratPerintahKerja() */
                                            'dataType' => 'json',
                                            'data'     => new JsExpression('function(params) { return {q:params.term}; }'),
                                            'delay'    => 1000
                                        ],
                                        'escapeMarkup'       => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult'     => new JsExpression('function(result) { return result.text; }'),
                                        'templateSelection'  => new JsExpression('function (result) { return result.text; }'),
                                    ],
                                ]);
                            // ->textInput(['placeholder' => 'Pilih SPK dari Web']) // From Web
                            ?>
                        </div>
                        <div id="spk-dos-wrapper" class="<?= $initial === 'web' ? 'd-none' : '' ?>">
                            <?= $form->field($model, 'surat_perintah_kerja_dos')->textInput(['placeholder' => 'Isi nomor SPK dari DOS']) // From DOS                                               ?>
                        </div>
                    </div>

                    <?php
                    $js = <<<JS
                    (function(){
                        var btns = document.querySelectorAll('.spk-source-choose');
                        var webWrap = document.getElementById('spk-web-wrapper');
                        var dosWrap = document.getElementById('spk-dos-wrapper');
                        var label = document.getElementById('spk-source-label');
                        var webInput = document.getElementById('$inputIdWeb');
                        var dosInput = document.getElementById('$inputIdDos');

                        function setMode(mode){
                            if(mode === 'web'){
                                if (dosWrap) dosWrap.classList.add('d-none');
                                if (webWrap) webWrap.classList.remove('d-none');
                                if (label) label.textContent = 'From Web';
                                if (dosInput) { dosInput.value = ''; dosInput.dispatchEvent(new Event('change')); }
                            } else {
                                if (webWrap) webWrap.classList.add('d-none');
                                if (dosWrap) dosWrap.classList.remove('d-none');
                                if (label) label.textContent = 'From DOS';
                                if (webInput) { webInput.value = ''; webInput.dispatchEvent(new Event('change')); }
                            }
                        }

                        btns.forEach(function(a){
                            a.addEventListener('click', function(e){
                                e.preventDefault();
                                var mode = this.getAttribute('data-mode');
                                setMode(mode);
                            });
                        });
                    })();
                    JS;
                    $this->registerJs($js);
                    ?>
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