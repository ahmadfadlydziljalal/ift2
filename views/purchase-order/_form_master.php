<?php


/* @var $this View */
/* @var $form ActiveForm */

/* @var $model PurchaseOrder */

use app\models\PurchaseOrder;
use kartik\datecontrol\DateControl;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>

<div class="form-master">
    <div class="row">
        <div class="col-12 col-lg-7">

            <?= Html::activeHiddenInput($model, 'material_requisition_id') ?>
            <?= Html::activeHiddenInput($model, 'vendor_id') ?>
            
            <?= $form->field($model, 'tanggal')->widget(DateControl::class, ['type' => DateControl::FORMAT_DATE,]) ?>
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