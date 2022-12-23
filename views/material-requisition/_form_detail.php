<?php


/* @var $this View */
/* @var $form ActiveForm */

/* @var $modelsDetail MaterialRequisitionDetail[] */

use app\models\Barang;
use app\models\BarangSatuan;
use app\models\MaterialRequisitionDetail;
use app\models\TipePembelian;
use kartik\depdrop\DepDrop;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>


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
      'formFields' => ['id', 'material_requisition_id', 'barang_id', 'description', 'quantity', 'satuan_id', 'waktu_permintaan_terakhir', 'harga_terakhir', 'stock_terakhir',],
   ]);
   ?>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="8">Material requisition detail</th>
            </tr>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tipe</th>
                <th scope="col">Barang</th>
                <th scope="col">Description</th>
                <th scope="col">Quantity</th>
                <th scope="col">Satuan</th>
                <th scope="col" style="width: 2px">Aksi</th>
            </tr>
            </thead>

            <tbody class="container-items">

            <?php foreach ($modelsDetail as $i => $modelDetail): ?>
                <tr class="item">

                    <td style="width: 2px;" class="align-middle">
                       <?php if (!$modelDetail->isNewRecord) {
                          echo Html::activeHiddenInput($modelDetail, "[$i]id");
                       } ?>
                        <i class="bi bi-arrow-right-short"></i>
                    </td>

                    <td><?= $form->field($modelDetail, "[$i]tipePembelian", ['template' =>
                          '{input}{error}{hint}', 'options' => ['class' => null]])
                          ->dropDownList(TipePembelian::find()->map(), [
                             'prompt' => '-',
                             'class' => 'tipe-pembelian',
                             'id' => 'materialrequisitiondetail-' . $i . '-tipepembelian'
                          ])
                       ?>
                    </td>

                    <td class="column-barang">
                       <?php
                       $data = [];

                       if (Yii::$app->request->isPost || !$modelDetail->isNewRecord) {
                          if ($modelDetail->barang_id) {
                             $data = Barang::find()->map($modelDetail->tipePembelian);
                          }
                       }

                       ?>

                       <?= $form->field($modelDetail, "[$i]barang_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                          ->widget(DepDrop::class, [
                             'data' => $data,
                             'options' => [
                                'id' => 'materialrequisitiondetail-' . $i . '-barang_id',
                                'placeholder' => '= Pilih nama barang =',
                                'class' => 'form-control barang-id',
                             ],
                             'type' => DepDrop::TYPE_SELECT2,
                             'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                             'pluginOptions' => [
                                'depends' => ['materialrequisitiondetail-' . $i . '-tipepembelian'],
                                'url' => Url::to(['barang/depdrop-find-barang-by-tipe-pembelian'])
                             ]
                          ]);
                       ?>
                    </td>
                    <td>
                       <?= $form->field($modelDetail, "[$i]description", ['template' =>
                          '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                          'class' => 'form-control description'
                       ]); ?></td>
                    <td>
                       <?= $form->field($modelDetail, "[$i]quantity", ['template' =>
                          '{input}{error}{hint}', 'options' => ['class' => null]])->textInput([
                          'class' => 'form-control quantity',
                          'type' => 'number'
                       ]) ?></td>
                    <td>
                       <?php
                       $data2 = [];
                       if (Yii::$app->request->isPost || !$modelDetail->isNewRecord) {
                          if ($modelDetail->satuan_id) {
                             $data2 = BarangSatuan::find()->mapSatuan($modelDetail->barang_id);
                          }
                       }
                       ?>
                       <?= $form->field($modelDetail, "[$i]satuan_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                          ->widget(DepDrop::class, [
                             'data' => $data2,
                             'pluginOptions' => [
                                'depends' => [
                                   'materialrequisitiondetail-' . $i . '-barang_id'
                                ],
                                'placeholder' => 'Select...',
                                'url' => Url::to(['barang/depdrop-find-satuan-by-barang'])
                             ],
                             'options' => [
                                'class' => 'form-control satuan-id'
                             ]
                          ]);
                       ?>
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

                <td class="text-end" colspan="7">
                   <?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah', ['class' => 'add-item btn btn-success',]); ?>
                </td>

            </tr>
            </tfoot>
        </table>
    </div>

   <?php DynamicFormWidget::end(); ?>
</div>