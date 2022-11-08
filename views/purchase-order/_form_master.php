<?php


/* @var $this View */
/* @var $form ActiveForm */

/* @var $model PurchaseOrder */

use app\models\Card;
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
            
            <?= $form->field($model, 'approved_by_id')->dropDownList(
                Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR), [
                    'prompt' => '= Pilih orang kantor ='
                ]
            ); ?>
            <?= $form->field($model, 'acknowledge_by_id')->dropDownList(
                Card::find()->map(Card::GET_ONLY_PEJABAT_KANTOR), [
                    'prompt' => '= Pilih orang kantor ='
                ]
            ); ?>
        </div>
    </div>
</div>