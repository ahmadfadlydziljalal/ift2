<?php


/* @var $this View */
/* @var $form ActiveForm */

/* @var $model PurchaseOrder */

use app\models\Card;
use app\models\PurchaseOrder;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

?>

<div class="form-master">
    <div class="row">
        <div class="col-12 col-lg-7">
            
            <?= $form->field($model, 'vendor_id')->widget(Select2::class, [
                'data' => Card::find()->map(Card::GET_ONLY_VENDOR),
                'options' => [
                    'prompt' => '= Pilih Salah Satu Vendor =',
                    'autofocus' => 'autofocus'
                ]
            ]) ?>
            <?= $form->field($model, 'tanggal')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
            <?= $form->field($model, 'reference_number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

            <?php
            if ($model->isNewRecord) {
                $settings = Yii::$app->settings;
                $model->approved_by = $settings->get('purchase_order.approved_by_nama');
                $model->acknowledge_by = $settings->get('purchase_order.acknowledge_by_nama');
            }

            echo $form->field($model, 'approved_by')->textInput(['maxlength' => true]);
            echo $form->field($model, 'acknowledge_by')->textInput(['maxlength' => true])
            ?>
        </div>
    </div>
</div>