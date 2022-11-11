<?php


/* @var $this View */
/* @var $form ActiveForm */

/* @var $model PurchaseOrder */

use app\models\Card;
use app\models\PurchaseOrder;
use kartik\datecontrol\DateControl;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

?>

<div class="form-master">
    <div class="row">
        <div class="col-12 col-lg-7">

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