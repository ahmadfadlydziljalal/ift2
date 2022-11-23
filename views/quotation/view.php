<?php

use app\enums\TextLinkEnum;
use mdm\admin\components\Helper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Quotation */
/* @see app\controllers\QuotationController::actionView() */

$this->title = $model->nomor;
$this->params['breadcrumbs'][] = ['label' => 'Quotation', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="quotation-view">

    <div class="d-flex justify-content-between flex-wrap mb-3 mb-md-3 mb-lg-0" style="gap: .5rem">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="d-flex flex-row flex-wrap align-items-center" style="gap: .5rem">
            <?= Html::a('Index', ['index'], ['class' => 'btn btn-outline-primary']) ?>
            <?= Html::a('Buat Lagi', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="d-flex flex-row gap-2 mb-3">
        <?= Html::a(TextLinkEnum::KEMBALI->value, Yii::$app->request->referrer, ['class' => 'btn btn-outline-secondary']) ?>
        <?= Html::a(TextLinkEnum::PRINT->value, ['print', 'id' => $model->id], [
            'class' => 'btn btn-outline-success',
            'target' => '_blank',
            'rel' => 'noopener noreferrer'
        ]) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-outline-primary']) ?>
        <?php
        if (Helper::checkRoute('delete')) :
            echo Html::a('Hapus', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-outline-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        endif;
        ?>
    </div>

    <?= $this->render('_view_quotation', ['model' => $model]) ?>
    <?= $this->render('_view_quotation_barang', ['model' => $model]) ?>
    <?= $this->render('_view_quotation_service', ['model' => $model]) ?>
    <?= $this->render('_view_quotation_term_and_condition', ['model' => $model]) ?>

</div>