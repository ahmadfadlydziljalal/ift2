<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PurchaseOrder */
/* @var $modelsDetail app\models\PurchaseOrderDetail */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="purchase-order-form">

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

        <?= $this->render('_form_master', ['form' => $form, 'model' => $model]) ?>
        <?= $this->render('_form_detail', ['form' => $form, 'modelsDetail' => $modelsDetail]); ?>

        <div class="d-flex flex-row flex-wrap">

            <div>
                <?php if ($model->isNewRecord): ?>
                    <?= Html::a('<i class="bi bi-arrow-left-circle"></i> Kembali ke langkah pertama', ['purchase-order/before-create'], ['class' => 'btn btn-secondary']) ?>
                <?php endif ?>
                <?= Html::a(' Tutup', ['index'], ['class' => 'btn btn-secondary']) ?>
            </div>

            <div class="ms-auto">
                <?= Html::submitButton('<i class="bi bi-save"></i> Simpan Purchase Order', ['class' => 'btn btn-success']) ?>
            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>