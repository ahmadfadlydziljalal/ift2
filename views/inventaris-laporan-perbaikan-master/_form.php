<?php

use app\models\Card;
use app\models\Inventaris;
use app\models\Status;
use kartik\datecontrol\DateControl;
use kartik\datetime\DateTimePicker;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InventarisLaporanPerbaikanMaster */
/* @var $modelsDetail app\models\InventarisLaporanPerbaikanDetail */
/* @var $form yii\bootstrap5\ActiveForm */
?>

    <div class="inventaris-laporan-perbaikan-master-form">

       <?php $form = ActiveForm::begin([
          'id' => 'dynamic-form',
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

        <div class="d-flex flex-column mt-0" style="gap: 1rem">

            <div class="form-master">
                <div class="row">
                    <div class="col-12 col-lg-6">

                       <?= $form->field($model, 'tanggal')->widget(DateControl::class, [
                          'type' => DateControl::FORMAT_DATE,
                          'pluginOptions' => [
                             'autofocus' => 'autofocus'
                          ]
                       ]) ?>

                       <?= $form->field($model, 'card_id')->widget(Select2::class, [
                          'data' => Card::find()->map(),
                          'options' => [
                             'placeholder' => '= Pilih salah satu ='
                          ]
                       ])->hint(false) ?>

                       <?= $form->field($model, 'status_id')->dropDownList(Status::find()->map(Status::SECTION_STATUS_EQUIPMENT_TOOL_REPAIR_REQUEST)) ?>

                       <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

                       <?= $form->field($model, 'approved_by_id')->dropDownList(Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR), [
                          'prompt' => '= Pilih salah satu ='
                       ]) ?>

                       <?= $form->field($model, 'known_by_id')->dropDownList(Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR), [
                          'prompt' => '= Pilih salah satu ='
                       ]) ?>
                    </div>
                </div>
            </div>

            <div class="form-detail">

               <?php
               DynamicFormWidget::begin([
                  'widgetContainer' => 'dynamicform_wrapper',
                  'widgetBody' => '.container-items',
                  'widgetItem' => '.item',
                  'limit' => 100,
                  'min' => 1,
                  'insertButton' => '.add-item',
                  'deleteButton' => '.remove-item',
                  'model' => $modelsDetail[0],
                  'formId' => 'dynamic-form',
                  'formFields' => ['id', 'inventaris_laporan_perbaikan_master_id', 'inventaris_id', 'kondisi_id', 'last_location_id', 'last_repaired', 'remarks', 'estimated_price',],
               ]);
               ?>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>

                        <tr class="text-nowrap text-center">
                            <th scope="col">#</th>
                            <th scope="col">Inventaris</th>
                            <th scope="col">Kondisi</th>
                            <th scope="col">Task</th>

                            <!--                            <th scope="col">Last location</th>-->
                            <!--                            <th scope="col">Last repaired</th>-->
                            <!--                            <th scope="col">Remarks</th>-->
                            <!--                            <th scope="col">Estimated price</th>-->
                            <th scope="col" style="width: 2px">Aksi</th>
                        </tr>
                        </thead>

                        <tbody class="container-items">

                        <?php
                        $formOptions = [
                           'template' => '{input}{error}{hint}',
                           'options' => ['class' => null]
                        ]; ?>

                        <?php foreach ($modelsDetail as $i => $modelDetail): ?>
                            <tr class="item align-middle">

                                <td style="width: 2px;" class="align-middle">
                                   <?php if (!$modelDetail->isNewRecord) {
                                      echo Html::activeHiddenInput($modelDetail, "[$i]id");
                                   } ?>
                                    <i class="bi bi-arrow-right-short"></i>
                                </td>

                                <td>
                                   <?= $form->field($modelDetail, "[$i]inventaris_id", $formOptions)
                                      ->widget(Select2::class, [
                                         'data' => Inventaris::find()->map(),
                                         'options' => [
                                            'placeholder' => '= Pilih salah satu ='
                                         ]
                                      ]);
                                   ?>
                                </td>

                                <td>
                                   <?= $form->field($modelDetail, "[$i]kondisi_id", [
                                      'template' => '{label}{input}{error}{hint}',
                                      'options' => ['class' => null]
                                   ])
                                      ->dropDownList(Status::find()->map(Status::SECTION_KONDISI_EQUIPMENT_TOOL_REPAIR_REQUEST), [
                                         'prompt' => '= Pilih salah satu ='
                                      ]);
                                   ?>

                                   <?= $form->field($modelDetail, "[$i]last_location_id", [
                                      'template' => '{label}{input}{error}{hint}',
                                      'horizontalCssClasses' => [
                                         'label' => 'col-sm-12 col-form-label',
                                      ],
                                      'options' => ['class' => null]
                                   ])
                                      ->dropDownList(Card::find()->map(Card::GET_ONLY_WAREHOUSE), [
                                         'prompt' => '= Pilih salah satu ='
                                      ]);
                                   ?>

                                   <?= $form->field($modelDetail, "[$i]last_repaired", [
                                      'template' => '{label}{input}{error}{hint}',
                                      'horizontalCssClasses' => [
                                         'label' => 'col-sm-12 col-form-label',
                                      ],
                                      'options' => ['class' => null]
                                   ])->widget(DateTimePicker::class, [
                                      'options' => [
                                         'class' => 'datetime-picker'
                                      ]
                                   ]);
                                   ?>
                                </td>

                                <td>
                                   <?= $form->field($modelDetail, "[$i]remarks", [
                                      'template' => '{label}{input}{error}{hint}',
                                      'horizontalCssClasses' => [
                                         'label' => 'col-sm-12 col-form-label',
                                      ],
                                      'options' => ['class' => null]
                                   ])->textarea(['rows' => 4]); ?>

                                   <?= $form->field($modelDetail, "[$i]estimated_price", [
                                      'template' => '{label}{input}{error}{hint}',
                                      'horizontalCssClasses' => [
                                         'label' => 'col-sm-12 col-form-label',
                                      ],
                                      'options' => ['class' => null]
                                   ])->widget(NumberControl::class); ?>

                                </td>

                                <td>
                                    <button type="button" class="remove-item btn btn-link text-danger">
                                        <i class="bi bi-trash"> </i>
                                    </button>
                                </td>

                            </tr>
                        <?php endforeach; ?>

                        </tbody>

                        <tfoot>
                        <tr>
                            <td class="text-end" colspan="4">
                               <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-success',]); ?>
                            </td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

               <?php DynamicFormWidget::end(); ?>
            </div>

            <div class="d-flex justify-content-between">
               <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
               <?= Html::submitButton(' Simpan', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

       <?php ActiveForm::end(); ?>

    </div>


<?php
$js = <<<JS
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    
    let element = jQuery(item);
    let dateTimePicker = element.closest('tr').find('.datetime-picker');
    
    jQuery(dateTimePicker).datetimepicker({
         autoclose: true,
         minuteStep: 1,
         position: 'top',
         todayHighlight: true,
         format: 'dd-mm-yyyy hh:ii'
    });
    
});
JS;

$this->registerJs($js);