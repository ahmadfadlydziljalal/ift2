<?php

use app\models\Barang;
use app\models\BarangSatuan;
use app\models\TipePembelian;
use kartik\depdrop\DepDrop;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $i int|string */
/* @var $model app\models\ClaimPettyCash */
/* @var $modelsDetail app\models\ClaimPettyCashNota */
/* @var $modelsDetailDetail app\models\ClaimPettyCashNotaDetail */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-rooms',
    'widgetItem' => '.room-item',
    'limit' => 99,
    'min' => 1,
    'insertButton' => '.add-room',
    'deleteButton' => '.remove-room',
    'model' => $modelsDetailDetail[0],
    'formId' => 'dynamic-form',
    'formFields' => ['id', 'claim_petty_cash_nota_id', 'tipe_pembelian_id', 'barang_id', 'description', 'quantity', 'satuan_id', 'harga',],
]); ?>

    <table class="table table-bordered">

        <thead class="thead-light">
        <tr>
            <th colspan="8">
                <i class="bi bi-arrow-right-short"></i>
                <i class="bi bi-arrow-right-short"></i> Nota detail
            </th>
        </tr>
        <tr>

            <th scope="col">Tipe</th>
            <th scope="col">Barang atau Perlengkapan</th>
            <th scope="col">Description</th>
            <th scope="col" style="width: 124px">Qty</th>
            <th scope="col" style="width: 96px">Satuan</th>
            <th scope="col">Harga</th>
            <th scope="col" class="text-center"
                style="width: 2px"></th>
        </tr>
        </thead>
        <tbody class="container-rooms">
        <?php foreach ($modelsDetailDetail as $j => $modelDetailDetail): ?>
            <tr class="room-item">

                <td class="column-tipe-pembelian">

                    <?php if (!$modelDetailDetail->isNewRecord) {
                        echo Html::activeHiddenInput($modelDetailDetail, "[$i][$j]id");
                    } ?>

                    <?php try {
                        echo $form->field($modelDetailDetail, "[$i][$j]tipePembelian", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                            ->dropDownList(TipePembelian::find()->map(), [
                                'prompt' => '-',
                                'class' => 'tipe-pembelian',
                                'id' => 'claim-petty-cash-nota-detail-' . $i . '-' . $j . '-tipe_pembelian_id'
                            ]);
                    } catch (InvalidConfigException $e) {
                        echo $e->getMessage();
                    }
                    ?>

                </td>

                <td class="column-barang">
                    <?php
                    $data = [];

                    if (Yii::$app->request->isPost || !$modelDetailDetail->isNewRecord) {
                        if ($modelDetailDetail->barang_id) {
                            $data = Barang::find()->map($modelDetailDetail->tipePembelian);
                        }
                    }

                    ?>

                    <?= $form->field($modelDetailDetail, "[$i][$j]barang_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                        ->widget(DepDrop::class, [
                            'data' => $data,
                            'options' => [
                                'id' => 'claim-petty-cash-nota-detail-' . $i . '-' . $j . '-barang_id',
                                'placeholder' => 'Select ...',
                                'class' => 'form-control barang',
                            ],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => ['claim-petty-cash-nota-detail-' . $i . '-' . $j . '-tipe_pembelian_id'],
                                'placeholder' => 'Select...',
                                'url' => Url::to(['barang/depdrop-find-barang-by-tipe-pembelian'])
                            ]
                        ]);
                    ?>
                </td>

                <td class="column-description">
                    <?= $form->field($modelDetailDetail, "[$i][$j]description", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                        ->textInput([
                            'class' => 'form-control description'
                        ]);
                    ?>
                </td>
                <td style="width: 12px">
                    <?= $form->field($modelDetailDetail, "[$i][$j]quantity", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                        ->textInput([
                            'class' => 'form-control quantity',
                            'type' => 'number'
                        ]);
                    ?>
                </td>
                <td>
                    <?php
                    $data2 = [];
                    if (Yii::$app->request->isPost || !$modelDetailDetail->isNewRecord) {
                        if ($modelDetailDetail->satuan_id) {
                            $data2 = BarangSatuan::find()->mapSatuan($modelDetailDetail->barang_id);
                        }
                    }
                    ?>
                    <?= $form->field($modelDetailDetail, "[$i][$j]satuan_id", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                        ->widget(DepDrop::class, [
                            'data' => $data2,
                            'pluginOptions' => [
                                'depends' => [
                                    'claim-petty-cash-nota-detail-' . $i . '-' . $j . '-barang_id'
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
                <td><?= $form->field($modelDetailDetail, "[$i][$j]harga", ['template' => '{input}{error}{hint}', 'options' => ['class' => null]])
                        ->widget(MaskedInput::class, [
                            'clientOptions' => [
                                'alias' => 'numeric',
                                'digits' => 2,
                                'groupSeparator' => ',',
                                'radixPoint' => '.',
                                'autoGroup' => true,
                                'autoUnmask' => true,
                                'removeMaskOnSubmit' => true
                            ],
                            'options' => [
                                'class' => 'form-control harga'
                            ]
                        ]);
                    ?>
                </td>

                <td class="text-center" style="width: 2px;">
                    <button type="button" class="remove-room btn btn-link text-danger px-2">
                        <i class="bi bi-trash"> </i>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>

            <td colspan="7"><?php echo Html::button('<span class="bi bi-plus-circle"></span> Tambah Detail Nota', ['class' => 'add-room btn btn-success',]); ?></td>
        </tr>
        </tfoot>

    </table>
<?php DynamicFormWidget::end(); ?>